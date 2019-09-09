<?php

/*
 * This file is part of ibrand/EC-Open-Server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\EC\Open\Server\Http\Controllers;

use Carbon\Carbon;
use iBrand\Component\Advert\Models\MicroPage;
use iBrand\Component\Advert\Models\MicroPageAdvert;
use iBrand\Component\Advert\Repositories\AdvertItemRepository;
use iBrand\Component\Product\Repositories\GoodsRepository;
use DB;

class MicroPageController extends Controller
{
    protected $microPage;

    protected $microPageAdvert;

    protected $advertItemRepository;

    public function __construct(MicroPage $microPage,
                                microPageAdvert $microPageAdvert,
                                AdvertItemRepository $advertItemRepository,
                                GoodsRepository $goodsRepository

    )
    {
        $this->microPage = $microPage;

        $this->microPageAdvert = $microPageAdvert;

        $this->advertItemRepository = $advertItemRepository;

        $this->goodsRepository = $goodsRepository;
    }

    public function index($code)
    {
        $data['pages'] = null;

        switch ($code) {
            case is_numeric($code):
                $microPage = $this->microPage->where('id', $code)->first();
                break;
            case 'index':
                $microPage = $this->microPage->where('page_type', 2)->first();
                break;
            default:
                $microPage = $this->microPage->where('code', $code)->first();
        }

        if (!$microPage) return $this->api();

        $microPageAdverts = $this->microPageAdvert->where('micro_page_id', $microPage->id)
            ->with(['advert' => function ($query) {

                return $query = $query->where('status', 1);
            }])
            ->orderBy('sort')->get();

        if ($microPageAdverts->count()) {

            $i = 0;

            foreach ($microPageAdverts as $key => $item) {

                $associate_with = [];

                if ($item->advert_id > 0) {

                    $data['pages'][$i]['name'] = $item->advert->type;

                    $data['pages'][$i]['title'] = $item->advert->title;

                    $data['pages'][$i]['is_show_title'] = $item->advert->is_show_title;


                    if (stristr($item->advert->type, 'componet_cube')) {

                        $data['pages'][$i]['name'] = 'micro_page_componet_cube';

                        $cube_type = '1_1';

                        $arr = explode('_', $item->advert->type);

                        $len = count($arr);

                        if (is_numeric($arr[$len - 1])) {

                            $cube_type = $arr[$len - 2] . '_' . $arr[$len - 1];
                        }

                        $data['pages'][$i]['type'] = $cube_type;

                    }

                    $advertItem = $this->getAdvertItem($item->advert->code, $associate_with);

                    $data['pages'][$i]['value'] = array_values($advertItem);


                }

                if ($item->advert_id == -1) {

                    $data['pages'][$i]['name'] = 'micro_page_componet_search';

                    $data['pages'][$i]['value'] = null;
                }

                $i++;


            }

        }

        $data['server_time'] = Carbon::now()->toDateTimeString();

        $data['micro_page'] = $microPage;

        return $this->api($data);
    }


    public function getAdvertItem($code, $associate_with)

    {
        $advertItem = $this->advertItemRepository->getItemsByCode($code, $associate_with);

        $time = Carbon::now()->toDateTimeString();

        if ($advertItem->count()) {

            $filtered = $advertItem->filter(function ($item) use ($time) {

                if (!$item->associate AND $item->associate_id) return [];

                switch ($item->associate_type) {
                    case 'discount':

                        if ($item->associate->status == 1 AND $item->associate->ends_at > $time) {

                            return $item;
                        }

                        break;

                    case 'category':

                        $category_id = $item->associate_id;

                        $categoryGoodsIds = DB::table('el_goods_category')->where('category_id', $category_id)
                            ->select('goods_id')->distinct()->get()
                            ->pluck('goods_id')->toArray();

                        $goodsList = DB::table('el_goods')
                            ->whereIn('id', $categoryGoodsIds)
                            ->where('is_del', 0)->where('is_largess', 0)
                            ->orderBy('sort', 'desc')->limit($item->meta['limit'])->get();

                        $item->goodsList = $goodsList;

                        return $item;

                        break;

                    case null:

                        if ($item->children AND $item->children->count()) {

                            foreach ($item->children as $citem) {

                                if ($citem->associate_type == 'goods') {

                                    $citem->goods_id = $citem->associate_id;
                                }


                            }
                        }

                        return $item;

                        break;

                    default:

                        return $item;

                }

            });

            return $filtered->all();
        }

        return $advertItem;

    }


}
