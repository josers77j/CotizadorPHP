<?php
function get_view($view_name)
{
    $view = VIEWS . $view_name . 'View.php';
    if (!is_file($view)) {
        die('la pagina no existe');
    }
    require_once $view;
}
//quote[]
/**
 * number
 * name
 * company
 * email
 * items[]
 * subtotal
 * taxes
 * shipping
 * total
 */

/**
 * item
 *id
 *concept
 *type
 *quantity
 *price
 *taxes
 *total
 */

/**
 * get_quote()
 * get_items()
 * get_items(id)
 * add_items(item)
 * delete_item(id)
 * delete_items()
 * restart_quote()
 */


function get_quote()
{
    if (!isset($_SESSION['new_quote'])) {
        return $_SESSION['new_quote'] = [
            'number' => rand(111111, 999999),
            'name' => '',
            'company' => '',
            'email' => '',
            'items' => [],
            'subtotal' => 0,
            'taxes' => 0,
            'shipping' => 0,
            'total' => 0,
        ];
    }
    recalculate_quote();

    return $_SESSION['new_quote'];
}

function recalculate_quote()
{
    $items      = [];
    $subtotal   = 0;
    $taxes      = 0;
    $shipping   = 0;
    $total      = 0;

    if (!isset($_SESSION['new_quote'])) {
        return false;
    }

    $items = $_SESSION['new_quote']['items'];

    if (!empty($items)) {
        foreach ($items as $item) {
            $subtotal += $item['total'];
            $taxes += $item['taxes'];
        }
    }

    $shipping = $_SESSION['new_quote']['shipping'];

    $total = $subtotal + $taxes + $shipping;

    $_SESSION['new_quote']['subtotal'] = $subtotal;
    $_SESSION['new_quote']['taxes'] = $taxes;
    $_SESSION['new_quote']['shipping'] = $shipping;
    $_SESSION['new_quote']['total'] = $total;
    return true;
}

function restart_quote()
{
    $_SESSION['new_quote'] = [
        'number' => rand(111111, 999999),
        'name' => '',
        'company' => '',
        'email' => '',
        'items' => [],
        'subtotal' => 0,
        'taxes' => 0,
        'shipping' => 0,
        'total' => 0,
    ];
    return true;
}

function get_items()
{
    $items = [];

    if (!isset($_SESSION['new_quote']['items'])) {
        return $items;
    }

    $items = $_SESSION['new_quote']['items'];
    return $items;
}

function get_item($id)
{
    $items = get_items();

    if (!empty($items)) {
        return false;
    }

    foreach ($items as $item) {
        if ($item['id' === $id]) {
            return $item;
        }
    }

    return false;
}

function delete_items()
{
    $_SESSION['new_quote']['items'] = [];

    recalculate_quote();

    return true;
}

function delete_item($id)
{
    $items = get_items();
    if (empty($items)) {
        return false;
    }

    foreach ($items as $i => $item) {
        if ($item['id'] === $id) {
            unset($_SESSION['new_quote']['items'][$i]);
            return $item;
        }
    }
    return false;
}

function add_item($item)
{
    $items = get_items();

    if (get_item($item['id']) !== false) {
        foreach ($items as $i => $e_item) {
            if ($item['id'] === $e_item['id']) {
                $_SESSION['new_quote']['items'][$i] = $item;
                return true;
            }
        }
    }

    $_SESSION['new_quote']['items'][] = $item;
    return true;
}

function json_build($status = 200, $data = null, $msg = '')
{
    if (empty($msg) || $msg == '') {
        switch ($status) {
            case 200:
                $msg = 'Ok';
                break;
            case 201:
                $msg = 'Created';
                break;
            case 400:
                $msg = 'Invalid request';
                break;
            case 403:
                $msg = 'Access denied';
                break;
            case 404:
                $msg = 'Not found';
                break;
            case 500:
                $msg = 'Internal Server Error';
                break;
            case 550:
                $msg = 'Permission denied';
                break;
            default:
                break;
        }
    }

    $json = 
    [
        'status' => $status,
        'data' => $data,
        'msg' => $msg

    ];
    return json_encode($json);
}

function json_output($json){
    header('Access-Control-Allow-Origins: *');
    header('Content-Type: application/json;charset=utf-8');

    if (is_array($json)) {
        $json = json_encode($json);
    }
    echo $json;

    return true;
}