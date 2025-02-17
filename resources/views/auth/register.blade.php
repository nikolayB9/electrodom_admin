<x-guest-layout>
    <div class="register-box">
        <div class="login-logo">
            <b>Electro</b>Dom
        </div>

        <div class="card mb-3">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Регистрация нового администратора</p>
                <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <x-input-with-icon name="name"
                                       placeholder="Имя"
                                       icon="fas fa-user"
                                       :messages="$errors->get('name')"
                                       required/>

                    <x-input-with-icon name="surname"
                                       placeholder="Фамилия"
                                       icon="fas fa-user"
                                       :messages="$errors->get('surname')"/>

                    <x-input-with-icon name="patronymic"
                                       placeholder="Отчество"
                                       icon="fas fa-user"
                                       :messages="$errors->get('patronymic')"/>

                    <x-input-with-icon type="email"
                                       name="email"
                                       placeholder="Эл.почта"
                                       icon="fas fa-envelope"
                                       :messages="$errors->get('email')"
                                       required/>

                    <x-input-with-icon name="phone_number"
                                       placeholder="Моб.телефон"
                                       icon="fas fa-phone"
                                       :messages="$errors->get('phone_number')"
                                       data-inputmask="&quot;mask&quot;: &quot;+7(999)9999999&quot;"
                                       data-mask=""
                                       inputmode="text"
                                       required/>

                    <x-select name="gender">
                        <option disabled selected>Выберите пол</option>
                        @foreach($genders as $gender)
                            <option @selected(old('gender') === (string)$gender['value'])
                                    value="{{ $gender['value'] }}">
                                {{ $gender['name'] }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-file name="image"
                                  help="Размер {{ $imgParams['width'] }}x{{ $imgParams['height'] }} px, не более {{ $imgParams['maximum_size'] }} Kb"
                                  :messages="$errors->get('image')"/>

                    <x-input-with-icon type="password"
                                       name="password"
                                       placeholder="Пароль"
                                       icon="fas fa-lock"
                                       :messages="$errors->get('password')"
                                       required/>

                    <x-input-with-icon type="password"
                                       name="password_confirmation"
                                       placeholder="Повторите пароль"
                                       icon="fas fa-lock"
                                       :messages="$errors->get('password_confirmation')"
                                       required/>

                    <div class="row mb-3">
                        <div class="col-5">
                        </div>
                        <div class="col-7">
                            <button type="submit" class="btn btn-primary btn-block">Регистрация</button>
                        </div>
                    </div>
                </form>

                <a href="{{ route('login') }}" class="text-center">У меня уже есть аккаунт</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
</x-guest-layout>
