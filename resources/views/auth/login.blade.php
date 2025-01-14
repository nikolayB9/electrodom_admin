<x-guest-layout>
    <div class="login-box">
        <div class="login-logo">
            <b>Electro</b>Dom
        </div>
        <!-- /.login-logo -->

        @if(!empty(session('status')))
            <x-alert-success :icon="false" :message="session('status')"/>
        @endif

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Вход в панель администратора</p>

                <form action="{{ route('login') }}" method="post"  id="quickForm">
                    @csrf

                    <x-input-with-icon type="email" name="email" placeholder="Эл.почта"
                                       icon="fas fa-envelope" :messages="$errors->get('email')" required />

                    <x-input-with-icon type="password" name="password" placeholder="Пароль"
                                       icon="fas fa-lock" :messages="$errors->get('password')" required/>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1 mt-2">
                    <a href="{{ route('password.request') }}" class="text-center">Забыли пароль?</a>
                </p>
                <p class="mb-1">
                    <a href="{{ route('register') }}" class="text-center">Регистрация</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</x-guest-layout>
