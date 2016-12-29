<?php

 ?>
 <script src="/js/ajaxAdmin.js" charset="utf-8"></script>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 text-left">
      <h4>Поиск пользователей</h4>
    </div>
    <div class="col-md-4">
      <input type="text" name="name" id="name" placeholder="Имя">
      <input type="text" name="surname" id="surname" placeholder="Фамилия">
      <input type="text" name="secondname" id="secondname" placeholder="Отчество">
    </div>
    <div class="col-md-4">
      <input type="date" id="birthday" name="birthday"><br>
      <input type="radio" id="male-radio" name="gender" value="male-radio"><label for="male-radio">Мужской</label>
      <input type="radio" id="female-radio" name="gender" value="female-radio" id="female-radio"><label for="female-radio">Женский</label><br>
      <input type="text" id="login" name="login" value="" placeholder="Логин">
    </div>
    <div class="col-md-4">
      <input type="text" name="interests" id="interests" placeholder="Интересы">
      <input type="tel" name="telephone" id="telephone" placeholder="Телефон">
      <input type="email" name="email" id="email" placeholder="E-mail">
    </div>
    <div class="col-md-4 col-md-offset-4 text-center">
      <!-- <input type="button" id="adminUserSearchBtn" value="allah"> -->
      <button id="test" class="test">Найти</button>
      <button>Отмена</button>
    </div>
  </div>
</div>
