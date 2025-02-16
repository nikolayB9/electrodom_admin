<x-app-layout>
    <x-content-header pageTitle="Профиль">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item active">Профиль</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">

                    @if (session('status') === 'profile-updated')
                        <x-alert-success message="Профиль успешно обновлен."/>
                    @endif

                    @if (session('status') === 'password-updated')
                        <x-alert-success message="Пароль успешно обновлен."/>
                    @endif

                    @if($errors->userDeletion->isNotEmpty())
                        <x-alert-danger :messages="$errors->userDeletion->get('password')"/>
                    @endif

                    <!-- Profile -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{ $user->getImageUrl() }}"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ $user->surname . ' ' . $user->name . ' ' . $user->patronymic }}
                            </h3>

                            <p class="text-muted text-center">{{ $user->getRoleName() }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Эл.почта</b> <a class="float-right">{{ $user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Номер моб.</b> <a class="float-right">{{ $user->phone_number }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Пол</b> <a class="float-right">{{ $user->getGenderName() }}</a>
                                </li>
                            </ul>

                            <div>
                                <a href="{{ route('profile.edit') }}"
                                   class="btn btn-primary float-right">Редактировать</a>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Edit password -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Изменить пароль</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('password.update') }}" method="post">
                            @csrf
                            @method('put')
                            <div class="card-body pb-0 login-card-body">

                                <x-input-with-icon type="password"
                                                   name="current_password"
                                                   placeholder="Текущий пароль"
                                                   icon="fas fa-lock"
                                                   :messages="$errors->updatePassword->get('current_password')"
                                                   required/>

                                <x-input-with-icon type="password"
                                                   name="password"
                                                   placeholder="Новый пароль"
                                                   icon="fas fa-lock"
                                                   :messages="$errors->updatePassword->get('password')"
                                                   required/>

                                <x-input-with-icon type="password"
                                                   name="password_confirmation"
                                                   placeholder="Повторите пароль"
                                                   icon="fas fa-lock"
                                                   :messages="$errors->updatePassword->get('password_confirmation')"
                                                   required/>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- Delete account -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Удалить аккаунт</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body text-sm">
                            Как только ваша учетная запись будет удалена, все ее ресурсы и данные будут удалены
                            безвозвратно. Перед удалением вашей учетной записи, пожалуйста, загрузите любые данные или
                            информацию, которые вы хотите сохранить.

                        </div>
                        <!-- /.card-body -->

                        <!-- Button trigger modal delete account -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger float-right" data-toggle="modal"
                                    data-target="#modal-delete-account">
                                Удалить
                            </button>
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- Modal delete account -->
                    <div class="modal fade" id="modal-delete-account">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Удалить аккаунт безвозвратно?</h5>
                                </div>

                                <form action="{{ route('profile.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-body">
                                        <div class="mb-3 text-sm">
                                            Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда
                                            удалить свою учетную запись.
                                        </div>
                                        <x-input-with-label type="password" name="password" placeholder="Пароль"
                                                            required/>
                                    </div>

                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена
                                        </button>
                                        <button type="submit" class="btn btn-danger">Удалить аккаунт</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
