<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 21.08.18
 * Time: 12:55
 */

class Validation
{

    // Values
    private $fullname = "";
    private $email = "";
    private $address = "";
    private $postindex = "";
    private $study = "";
    // Errors
    private $fullnameErr = "";
    private $emailErr = "";
    private $addressErr = "";
    private $postIndexErr = "";
    // Result
    //private $error_form = false; //


    private function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validation(){
        if ($_SERVER["REQUEST_METHOD"]) {
            if(empty($_POST["fullname"])){
                $this->fullnameErr = "Потрібно ввести ім'я";
            } else {
                $this->fullname = $this->testInput($_POST["fullname"]);
                $this->fullnameErr = "";
                if (!preg_match("/^[a-zA-Z ]*$/",$this->fullname)) {
                    $this->fullnameErr = "Мають бути тільки букви та пробіли";
                }
            }

            if(empty($_POST["email"])){
                $this->emailErr = "Потрібно ввести email";
            } else {
                $this->email = $this->testInput($_POST["email"]);
                $this->emailErr = "";
                if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $this->emailErr = "Введений неправильний EMail";
                }
            }

            if(empty($_POST["address"])){
                $this->addressErr = "Потрібно ввести адресу";
            } else {
                $this->address = $this->testInput($_POST["address"]);
                $this->addressErr = "";
            }

            if(empty($_POST["postindex"])){
                $this->postIndexErr = "Потрібно ввести поштовий індекс";
            } else {
                $this->postIndex = $_POST["postindex"];
                $this->postIndexErr = "";
            }

            if(empty($_POST["study"])){
                $this->study = "";
            } else {
                $this->study = $this->testInput($_POST["study"]);
            }
        }
    }

    // Getting a values in case of valid input
    public function getName()
    {
        return $this->fullname;
    }

    public function  getEmail() {
        return $this->email;
    }

    public function getAdress() {
        return $this->address;
    }

    public function getPostIndex() {
        return $this->postindex;
    }

    public function getStudy() {
        return $this->study;
    }

    /* Getting an error string in case of invalid input.
    *  In other case it will output an empty string.
    */
    public function getNameError()
    {
        return $this->fullnameErr;
    }

    public function  getEmailError() {
        return $this->emailErr;
    }

    public function getAddressError() {
        return $this->addressErr;
    }

    public function getPostIndexError() {
        return $this->postIndexErr;
    }

    public function getMessage() {
        if(
              empty($this->fullnameErr)
           && empty($this->emailErr)
           && empty($this->addressErr)
           && empty($this->postIndexErr)
        ){
            return "Запис завершено";
        } else {
            return "Помилка в формі. Перевітре інформацію";
        }
    }
}

$checkValid = new Validation();
$checkValid->validation();

?>

<script>
    document.getElementById('invalid-name').innerHTML = "<?php echo $checkValid->getNameError(); ?>";
    document.getElementById('invalid-email').innerHTML = "<?php echo $checkValid->getEmailError(); ?>";
    document.getElementById('invalid-address').innerHTML = "<?php echo $checkValid->getAddressError(); ?>";
    document.getElementById('invalid-postindex').innerHTML = "<?php echo $checkValid->getPostIndexError(); ?>";
    document.getElementById('form-message').innerHTML = "<?php echo $checkValid->getMessage(); ?>";
</script>
