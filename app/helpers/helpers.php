<?php


use App\Models\Ayar;
use Illuminate\Support\Str;

function changeUIPhoneNumberToDbFormat($phone)
{
    $replacedText = ['(', ')', ' ', '-', '_'];
    return str_replace($replacedText, '', $phone);
}

function changeUIIbanNumberToDBFormat($ibanNumber)
{
    $replacedText = ['(', ')', ' ', '-', '_', '/', '['];
    return str_replace($replacedText, '', $ibanNumber);
}


function curLang()
{
    return session()->get('lang', config('app.locale'));
}

function curLangId()
{
    return session()->get('lang_id', config('admin.default_language'));
}


function defaultLangID()
{
    return config('admin.default_language');
}

function authAdminUserId()
{
    return Auth::user('admin')->id;
}

function authAdminUser()
{
    return Auth::user('admin');
}

/**
 * giriş yapmış kullanıcı bilgisi
 * @return \Illuminate\Contracts\Auth\Authenticatable|null
 */
function loggedPanelUser()
{
    return Auth::guard('panel')->user();
}


/**
 * giriş yapmış kullanıcının firma bilgisi
 * @return \Illuminate\Contracts\Auth\Authenticatable|null
 */
function loggedStoreUserCompany()
{
    return Auth::guard('panel')->user()->company;
}

function isSuperAdmin()
{
    return Auth::user('admin')->role_id == \App\Models\Auth\Role::ROLE_SUPER_ADMIN;
}

function langIcon($langId)
{
    return "/admin_files/dist/img/langs/" . \App\Models\Ayar::getLanguageImageNameById($langId);
}

function langTitle($langId)
{
    return Ayar::getLanguageLabelByLang($langId);
}

// ====== PARA BİRİMLERİ =============
/**
 * mevcut para birimi sembol getirir
 * @return mixed
 */
function currentCurrencySymbol()
{
    $currencyID = session()->get('currency_id', config('admin.default_currency'));
    return Ayar::getCurrencySymbolById($currencyID);
}

/**
 * mevcut para birimi getirir
 * @return mixed
 */
function currentCurrencyID()
{
    return Ayar::getCurrencyId();
}


/**
 *  gönderilen para birimine göre sembol getirir
 * @param int|string $currencyID para birimi id
 * @return mixed|string
 */
function getCurrencySymbolById($currencyID)
{
    return Ayar::getCurrencySymbolById($currencyID);
}

// ====== ./// CURRENCY =============

function createSlugByModelAndTitle($model, $title, $itemID)
{
    $i = 0;
    $slug = Str::slug($title);
    while ($model->all([['slug', $slug], ['id', '!=', $itemID]], ['id'])->count() > 0) {
        $slug = Str::slug($title) . '-' . $i;
        $i++;
    }
    return $slug;
}

/**
 *  create unique slug for model
 * @param $model
 * @param $title
 * @param $itemID
 * @return string
 */
function createSlugByModelAndTitleByModel($model, $title, $itemID)
{
    $i = 0;
    $slug = Str::slug($title);
    while ($model::where([['slug', $slug], ['id', '!=', $itemID]], ['id'])->count() > 0) {
        $slug = Str::slug($title) . '-' . $i;
        $i++;
    }
    return $slug;
}

function activeStatus($column = 'active')
{
    return (boolean)request()->has($column);
}

/**
 * @param string $folderPath public/categories
 * @param string|null $imageName imageName
 */
function imageUrl(string $folderPath, $imageName = '')
{
    return Storage::url($folderPath . '/' . $imageName);
}

// ======== Session MESSAGES =============

function success($message = null)
{
    $message = $message ? $message : __('lang.success_message');
    session()->flash('message', $message);
}

function error($message = null)
{
    $message = $message ? $message : __('lang.error_message');
    session()->flash('message', $message);
    session()->flash('message_type', 'danger');
}

/**
 * tarih formatı
 * @param string $dateTime
 */
function createdAt($dateTime)
{
    return $dateTime->format('d/m/Y H:m');
}

/**
 * tarih formatı
 * @param string $dateTime
 */
function startedAt($dateTime)
{
    return $dateTime->format('d/m/Y');
}


function commentColor($index)
{
    $bgColor = [
            1 => 'red',
            2 => '#ff4545',
            3 => '#fc7c7c',
            4 => 'yellow',
            5 => '#c49300',
            6 => '#a6eb05',
            7 => '#1dc902',
            8 => '#069e2f',
            9 => '#21c447',
            10 => 'green',
        ][$index] ?? '#dedede';

    $color = [
            1 => 'white',
            4 => 'black',
            10 => 'white'
        ][$index] ?? 'black';

    return "background-color : ${bgColor};color : $color";
}

function commentText($index)
{
    $index = ceil($index / 2);
    return [
            0 => 'Henüz yorum yok',
            1 => 'Kötü',
            2 => 'Olumsuz',
            3 => 'İdare Eder',
            4 => 'İyi',
            5 => 'Çok İyi'
        ][$index] ?? 'İyi';
}
