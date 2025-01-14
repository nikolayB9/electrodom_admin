<x-guest-layout>
    <div class="register-box">
        <div class="login-logo">
            <b>Electro</b>Dom
        </div>

        <div class="card mb-3">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Сброс пароля</p>

                <form action="{{ route('password.store') }}" method="post">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <x-input-with-icon type="email"
                                       name="email"
                                       :value="old('email', $request->email)"
                                       placeholder="Эл.почта"
                                       icon="fas fa-envelope"
                                       :messages="$errors->get('email')"
                                       required/>

                    <x-input-with-icon type="password"
                                       name="password"
                                       placeholder="Новый пароль"
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
                            <button type="submit" class="btn btn-primary btn-block">Подтвердить</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
</x-guest-layout>
