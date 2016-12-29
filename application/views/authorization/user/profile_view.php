<?php

$result_row;

for($row_no = $data->num_rows-1;$row_no>=0; $row_no--){
    $data->data_seek($row_no);
    $row=$data->fetch_assoc();
    if($_SESSION['userLogin'] === $row['User_login']){
      $result_row = $row;
    }
}

$value_name = 'value="' . $result_row['User_name'] . '"';
$value_surname = 'value="' . $result_row['User_surname'] . '"';
$value_secondname = 'value="' . $result_row['User_secondname'] . '"';
$value_telephone = 'value="' . $result_row['User_telephone'] . '"';
$value_interests = $result_row['User_interests'];
$value_email = 'value="' . $result_row['User_email'] . '"';
$login = $result_row['User_login'];
$status = $result_row['User_status'];

$ifUserSignIn = <<<EOF
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="first-profile-col">
                <div class="photo-profile">
                    <img src="" alt="Avatar" id="profile-ava">
                </div>
                <div class="upload-profile-photo tex-center">
                    <h4>Загрузить фото профиля</h4>
                    <input type="file" name="name" value="...">
                </div>
                <div class="select-sex-profile">
                    <h4>Пол:</h4>
                    <input type="radio" name="gender" id="male-radio" value="male" checked><label for="male-radio">Мужской</label>
                    <input type="radio" name="gender" id="female-radio" value="female"><label for="female-radio">Женский</label>
                </div>
                <div class="save-profile">
                    <button id="saveProfileBtn">Сохранить</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="second-profile-col text-center">
                <input type="text" name="name" id="name" placeholder="Ваше имя" $value_name>
                <input type="text" name="surname" id="surname" placeholder="Ваша фамилия" $value_surname>
                <input type="text" name="secondname" id="secondname" placeholder="Ваше отчество" $value_secondname>
                <h4 class="text-center">Дата рождения</h4>
                <input type="date" name="birthday">
                <input type="tel" name="telephone" id="telephone" placeholder="Ваш телефон" $value_telephone>
            </div>
        </div>
        <div class="col-md-4">
            <div class="third-profile-col">
                <h4>Ваши интересы</h4>
                <textarea name="interests" id="profile-interests-ta">$value_interests</textarea>
                <input type="email" id="email" name="email" $value_email placeholder="Ваш email">
            </div>
        </div>
    </div>
</div>
EOF;
$ifUserNotSignIn = <<<EOF
  allahy akbar;
EOF;

if($_SESSION['isUserCorrect']){
  echo $ifUserSignIn;
}else{
  echo $ifUserNotSignIn;
}
 ?>
