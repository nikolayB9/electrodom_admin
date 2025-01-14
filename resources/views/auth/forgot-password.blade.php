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
                <p class="login-box-msg">Укажите свой адрес электронной
                    почты для получения ссылки для сброса пароля.</p>

                <form action="{{ route('password.email') }}" method="post">
                    @csrf

                    <x-input-with-icon type="email"
                                       name="email"
                                       placeholder="Эл.почта"
                                       icon="fas fa-envelope"
                                       :messages="$errors->get('email')"
                                       required />

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Отправить ссылку</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}" class="text-center">Вход</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Регистрация</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</x-guest-layout>
