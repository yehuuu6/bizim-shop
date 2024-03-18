<?php

namespace Components\Forms;

use Components\Component;
use mysqli;

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

/**
 * Address form component
 */
class AddressForm extends Component
{
    private $address_info;

    public function __construct(mysqli $connection)
    {
        $this->address_info = $this->set_address_info($connection);
        $body = <<<HTML
            <form id="address-form">
            <h4>Adres Bilgileri <a class="link" href="/control-center/account">Düzenle <i class="fa-solid fa-pen-to-square"></i></a></h4>
                <div class="form-layout">
                    <div class="form-group">
                        <label for="name">Ad</label>
                        <input type="text" id="name" name="name" required readonly value="{$this->address_info['name']}">
                    </div>
                    <div class="form-group">
                        <label for="surname">Soyad</label>
                        <input type="text" id="surname" name="surname" required readonly value="{$this->address_info['surname']}">
                    </div>
                </div>
                <div class="form-layout">
                    <div class="form-group">
                        <label for="email">E-posta</label>
                        <input type="email" id="email" name="email" readonly value="{$this->address_info['email']}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input type="tel" id="phone" name="phone" required readonly value="{$this->address_info['telephone']}">
                    </div>
                </div>
                <div class="form-layout">
                    <div class="form-group">
                        <label for="city">Şehir</label>
                        <input type="text" id="city" name="city" required readonly value="{$this->address_info['city']}">
                    </div>
                    <div class="form-group">
                        <label for="district">İlçe</label>
                        <input type="text" id="district" name="district" required readonly value="{$this->address_info['district']}">
                    </div>
                </div>
                <div class="form-layout">
                    <div class="form-group">
                        <label for="apartment">Apartman</label>
                        <input type="text" id="apartment" name="apartment" required readonly value="{$this->address_info['apartment']}">
                    </div>
                    <div class="form-group">
                        <label for="floor">Kat</label>
                        <input type="text" id="floor" name="floor" required readonly value="{$this->address_info['floor']}">
                    </div>
                    <div class="form-group">
                        <label for="door">Daire</label>
                        <input type="text" id="door" name="door" required readonly value="{$this->address_info['door']}">
                    </div>
                </div>
                <div class="form-layout">
                    <div class="form-group">
                        <label for="address">Adres</label>
                        <textarea id="address" name="address" required readonly>{$this->address_info['address']}</textarea>
                    </div>
                </div>
            </form>
        HTML;

        parent::render($body);
    }

    private function set_address_info(mysqli $connection)
    {
        $sql = "SELECT name, surname, email, telephone, address, city, district, apartment, floor, door FROM users WHERE id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        $user['city'] = $this->get_city_name($user['city'], $connection);
        $user['district'] = $this->get_district_name($user['district'], $connection);
        return $user;
    }

    private function get_city_name($city_id, mysqli $connection)
    {
        $sql = "SELECT name FROM cities WHERE id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $city_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result)['name'];
    }

    private function get_district_name($district_id, mysqli $connection)
    {
        $sql = "SELECT name FROM districts WHERE id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $district_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result)['name'];
    }
}
