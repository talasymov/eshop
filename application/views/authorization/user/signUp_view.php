<section id="signUp">
    <div class="container">
        <div class="row">
            <div class="signUpForm">
                <div class="col-md-4">
                    <div class="login"><i class="fa fa-times-circle" aria-hidden="true"></i><input type="text"
                                                                                                   name="login"
                                                                                                   placeholder="Ваш Login*"
                                                                                                   id="sign_up_user_login">
                    </div>
                    <div class="password">
                        <i class="fa fa-times-circle" aria-hidden="true"></i><input type="password" name="password"
                                                                                    placeholder="Ваш пароль*"
                                                                                    id="sign_up_user_password">
                    </div>
                    <div class="password_confirm">
                        <i class="fa fa-times-circle" aria-hidden="true"></i><input type="password"
                                                                                    name="password_confirm"
                                                                                    placeholder="Подтвердите пароль*"
                                                                                    id="sign_up_user_password_confirm">
                    </div>
                    <div class="email">
                        <i class="fa fa-times-circle" aria-hidden="true"></i><input type="email" name="email"
                                                                                    placeholder="Ваш Email*"
                                                                                    id="sign_up_user_email">
                    </div>
                    <input type="tel" id="sign_up_user_telephone" placeholder="Ваш номер телефона">
                    <div class="name">
                        <i class="fa fa-times-circle" aria-hidden="true"></i><input type="text" name="name"
                                                                                    id="sign_up_user_name"
                                                                                    placeholder="Ваше имя*">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="surname">
                        <i class="fa fa-times-circle" aria-hidden="true"></i><input type="text" name="surname"
                                                                                    id="sign_up_user_surname"
                                                                                    placeholder="Ваша фамилия*">
                    </div>
                    <input type="text" name="patronymic" id="sign_up_user_patronymic" placeholder="Ваше отчество">
                    <h3>Дата рождения:</h3>
                    <input type="text" class="form-control" id="sign_up_user_birthdate">
                    <div class="gender">
                        <h3><i class="fa fa-venus-mars" aria-hidden="true"></i> Выберите пол</h3>
                        <button class="choiced" id="male"><i class="fa fa-mars" aria-hidden="true"></i> Мужской</button>
                        <button id="female"><i class="fa fa-venus" aria-hidden="true"></i> Женский</button>
                    </div>
                    <input type="text" id="sign_up_user_country" placeholder="Страна">
                    <input type="text" id="sign_up_user_state" placeholder="Область">
                </div>
                <div class="col-md-4">
                    <input type="text" id="sign_up_user_region" placeholder="Район">
                    <input type="text" id="sign_up_user_city" placeholder="Город">
                    <input type="text" id="sign_up_user_street" placeholder="Улица">
                    <input type="text" id="sign_up_user_buildNumber" placeholder="Номер дома">
                    <input type="text" id="sign_up_user_porch" placeholder="Подъезд">
                    <input type="text" id="sign_up_user_apartment" placeholder="Квартира">
                    <input type="text" id="sign_up_user_cityIndex" placeholder="Индекс города">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="submit">
                    <button id="signUpUserBtn">Регистрация</button>
                    <button id="cancelBtn">Отмена</button>
                </div>
            </div>
        </div>
    </div>
</section>
