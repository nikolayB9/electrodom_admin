<x-guest-layout>
    <div class="register-box">
        <div class="register-logo">
            Регистрация администратора
        </div>

        <div class="card mb-3">
            <div class="card-body register-card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <x-text-input name="name" placeholder="Имя" icon="fas fa-user" required></x-text-input>

                    <x-text-input name="surname" placeholder="Фамилия" icon="fas fa-user"></x-text-input>

                    <x-text-input name="patronymic" placeholder="Отчество" icon="fas fa-user"></x-text-input>

                    <x-text-input type="email" name="email" placeholder="Эл.почта"
                                  icon="fas fa-envelope" required></x-text-input>

                    <x-text-input name="phone_number"
                                  placeholder="Моб.телефон"
                                  icon="fas fa-phone"
                                  data-inputmask="&quot;mask&quot;: &quot;9(999)999-9999&quot;"
                                  data-mask=""
                                  inputmode="text"></x-text-input>

                    <div class="form-group">
                        <select class="form-control" name="gender">
                            <option disabled selected value="">Выберите пол</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender }}">{{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input"
                                       id="image"
                                       name="image">
                                <label class="custom-file-label" for="image">Изображение</label>
                            </div>
                        </div>
                        @error('image')
                        <div class="alert alert-danger text-sm mt-1 py-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <x-text-input type="password" name="password" placeholder="Пароль"
                                  icon="fas fa-lock" required></x-text-input>

                    <x-text-input type="password" name="password_confirmation" placeholder="Повторите пароль"
                                  icon="fas fa-lock" required></x-text-input>

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
