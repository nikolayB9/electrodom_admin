<x-guest-layout>
    <div class="login-box">
        <div class="login-logo">
            Вход в панель администратора
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Введите логин и пароль</p>

                <form method="POST" action="{{ route('login') }}" id="quickForm">
                    @csrf

                    <x-text-input type="email" name="email" placeholder="Email" icon="fas fa-envelope"></x-text-input>

                    <x-text-input type="password" name="password" placeholder="Пароль" icon="fas fa-lock"></x-text-input>

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

                <p class="mt-3">
                    <a href="{{ route('register') }}" class="text-center">Регистрация нового администратора</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</x-guest-layout>
