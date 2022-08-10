<?php

// tạo link
function makeLink($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'category_products':
            if ($slug) {
                $route = route("product.productByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'category_posts':
            if ($slug) {
                $route = route("post.postByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'post':
            if ($slug) {
                $route = route("post.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'post_index':
            $route = route("post.index");
            break;
        case 'product':
            if ($slug) {
                $route = route("product.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'product_all':
            $route = route("product.index");
            break;
        case 'exam_index':
            $route = route("exam.index");
            break;
        case 'category_exams':
            if ($slug) {
                $route = route("exam.examByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'exam':
            if ($slug) {
                $route = route("exam.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'program_index':
            $route = route("program.index");
            break;
        case 'category_programs':
            if ($slug) {
                $route = route("program.programByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'program':
            if ($slug) {
                $route = route("program.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'galaxy_index':
            $route = route("galaxy.index");
            break;
        case 'category_galaxies':
            if ($slug) {
                $route = route("galaxy.galaxyByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'galaxy':
            if ($slug) {
                $route = route("galaxy.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'faq_index':
            $route = route("faq.index");
            break;
        case 'category_faqs':
            if ($slug) {
                $route = route("faq.faqByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;

        case 'home':
            $route = route("home.index");
            break;
        case 'about-us':
            $route = route("about-us");
            break;
        case 'tuyen-dung':
            $route = route("tuyen-dung");
            break;
        case 'tuyen-dung-detail':
            if ($slug) {
                $route = route("tuyendung_link", ['slug' => $slug]);
            } else {
                $route = "#";
            }

            break;
        case 'contact':
            $route = route("contact.index");
            break;
        case 'search':
            $route = route("home.search", $request);
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}

function makeLinkById($type, $id = null)
{
    $route = "";
    switch ($type) {
        case 'category_products':
            $slug = optional(App\Models\CategoryProduct::find($id))->slug;
            if ($slug) {
                $route = route("product.productByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'category_posts':
            $slug = optional(App\Models\CategoryPost::find($id))->slug;

            if ($slug) {
                $route = route("post.postByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'post':
            $slug = optional(App\Models\Post::find($id))->slug;
            if ($slug) {
                $route = route("post.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'product':
            $slug = optional(App\Models\Product::find($id))->slug;
            if ($slug) {
                $route = route("product.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}



// make link program
function makeLinkProgram($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'index':
            $route = route("program.index");
            break;
        case 'category':
            if ($slug) {
                $route = route("program.programByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'program':
            if ($slug) {
                $route = route("program.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}
// make link product
function makeLinkProduct($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'index':
            $route = route("product.index");
            break;
        case 'category':
            if ($slug) {
                $route = route("product.productByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'product':
            if ($slug) {
                $route = route("product.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}

// make link product
function makeLinkPost($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'index':
            $route = route("post.index");
            break;
        case 'category':
            if ($slug) {
                $route = route("post.postByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'post':
            if ($slug) {
                $route = route("post.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}

// make link exam
function makeLinkExam($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'index':
            $route = route("exam.index");
            break;
        case 'category':
            if ($slug) {
                $route = route("exam.examByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'exam':
            if ($slug) {
                $route = route("exam.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}


// make link galaxy
function makeLinkGalaxy($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'index':
            $route = route("galaxy.index");
            break;
        case 'category':
            if ($slug) {
                $route = route("galaxy.galaxyByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'galaxy':
            if ($slug) {
                $route = route("galaxy.detail", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}

// make link faq
function makeLinkFaq($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'index':
            $route = route("faq.index");
            break;
        case 'category':
            if ($slug) {
                $route = route("faq.faqByCategory", ["slug" => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'faq':
            if ($slug) {
                $route = route("faq.detail", ["slug" => $slug, 'id' => $id]);
            } else {
                $route = "#";
            }
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}


function makeLinkToLanguage($type, $id = null, $slug = null, $lang = 'vi', $request = [])
{
    $route = "";
    if ($lang == 'vi') {
        $lang = "";
    } else {
        $lang = '.' . $lang;
    }
    switch ($type) {
        case 'about-us':
            $route = route("about-us" . $lang);
            break;
        case 'golf-course':
            $route = route("golf-course" . $lang);
            break;
        case 'features-golf':
            $route = route("features-golf" . $lang);
            break;
        case 'practicing-field':
            $route = route("practicing-field" . $lang);
            break;
        case 'academy':
            $route = route("academy" . $lang);
            break;
        case 'bao-gia':
            $route = route("bao-gia" . $lang);
            break;
        case 'tuyen-dung':
            $route = route("tuyen-dung" . $lang);
            break;
        case 'tuyen-dung-detail':
            if ($slug) {
                $route = route("tuyendung_link" . $lang, ['slug' => $slug]);
            } else {
                $route = "#";
            }
            break;
        case 'search-dai-ly':
            $route = route("search-daily" . $lang, $request);
            break;
        case 'contact':
            $route = route("contact.index" . $lang);
            break;
        case 'feed-back':
            $route = route("feed_back.index" . $lang);
            break;
        case 'feed-back2':
            $route = route("feed_back2.index" . $lang);
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}

function menuRecusive($model, $id, $result = array(), $i = 0)
{
    //  global $result;

    $i++;
    $data = $model->where('active', 1)->select(['id'])->orderby('order')->orderByDesc('created_at')->find($id)->setAppends(['slug_full','name']);
    $item = $data->toArray();

    $childs =  $data->childs()->where('active', 1)->select(['id'])->orderby('order')->orderByDesc('created_at')->get();
    foreach ($childs as $child) {
        //  $res  = $child->setAppends(['slug'])->toArray();
        $child=$child->setAppends(['slug_full','name']);
        $res =  menuRecusive($model, $child->id, []);
        // dd( $res );
        $item['childs'][] = $res;
    }
    //  dd($result);
    // array_push($result, $item);
    return $item;
}

function menuRecusive2($model, $id, $result = array(), $i = 0)
{
    //  global $result;
    $i++;
    $data = $model->mergeLanguage(['name','slug'])->where('active', 1)->find($id);
    $item = $data->toArray();
    $childs =  $data->childLs(['name','slug'])->where('active', 1)->orderby('order')->orderByDesc('created_at')->get();

    foreach ($childs as $child) {
        //  $res  = $child->setAppends(['slug'])->toArray();

        $res =  menuRecusive2($model, $child->id, []);
        // dd( $res );
        $item['childs'][] = $res;
    }
    //  dd($result);
    // array_push($result, $item);
    return $item;
}


// quy đổi tiền sang điểm
function moneyToPoint($money)
{
    $money = (int)$money;
    return $money / config('point.pointToMoney');
}
function pointToMoney($point)
{
    return (float)$point * config('point.pointToMoney');
}
function makeCodeTransaction($transaction)
{
    $code = 'mgd-' . date('Y-m-d-h-s-m');
    //  dd($code);
    while ($transaction->where([
        'code' => $code,
    ])->exists()) {
        $code = 'mgd-' . date('Y-m-d-h-s-m') . rand(1, 1000);
    }
    return $code;
}

function checkRouteLanguage($slug, $data)
{
    $lang = App::getLocale();
    $tran=$data->translationsLanguage($lang)->first();
    if(!$tran){
        return redirect()->route('home.index');
    }
    if ($slug != $tran->slug) {
        if(!$data->slug){
            return redirect()->route('home.index');
        }
        $name = Route::currentRouteName();
        return redirect()->route($name, ['slug' => $data->slug]);
    } else {
        return false;
    }
}
function checkRouteLanguage2($slug = null)
{
    // if(!$slug){
    //     return redirect()->route('home.index');
    // }
    $name = Route::currentRouteName();
    //  dd($name);
    $lang = App::getLocale();
    $langConfig = array_keys(config('languages.supported'));
    //  dd($langConfig);
    $langDefault = config('languages.default');
    //   dd($langDefault);

    // dd($lang!=$langDefault);
    $slice = '';
    $langCurrentOfRoute = '';
    foreach ($langConfig as $value) {
        if (Str::endsWith($name, '.' . $value)) {
            $slice = Str::before($name, '.' . $value);
            $langCurrentOfRoute = $value;
            break;
        }
    }
    if ($slice == '' && $langCurrentOfRoute == '') {
        $slice = $name;
        $langCurrentOfRoute = $langDefault;
    }
    if ($langCurrentOfRoute != $lang) {
        if ($lang == $langDefault) {

            return redirect()->route($slice, ['slug' => $slug]);
        } else {
            return redirect()->route($slice . '.' . $lang, ['slug' => $slug]);
        }
    } else {
        return false;
    }
}


function showFileSize($size)
{
    $sizeC = $size;
    $dv = 'B';
    if ($sizeC / 1024 >= 1) {
        $sizeC = $sizeC / 1024;
        $dv = 'KB';
        if ($sizeC / 1024 >= 1) {
            $sizeC = $sizeC / 1024;
            $dv = 'MB';
        }
    }

    return round($sizeC, 2) . " " . $dv;
}
