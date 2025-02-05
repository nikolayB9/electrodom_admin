<x-app-layout>
    <x-content-header pageTitle="Редактировать профиль">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">Профиль</a></li>
        <li class="breadcrumb-item active">Редактировать</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Поля для редактирования</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <x-input-with-label name="name"
                                                    :value="old('name') ?? $user->name"
                                                    label="Имя"
                                                    placeholder="Введите имя"
                                                    :messages="$errors->get('name')"
                                                    required/>

                                <x-input-with-label name="surname"
                                                    :value="old('surname') ?? $user->surname"
                                                    label="Фамилия"
                                                    placeholder="Введите фамилию"
                                                    :messages="$errors->get('surname')"/>

                                <x-input-with-label name="patronymic"
                                                    :value="old('patronymic') ?? $user->patronymic"
                                                    label="Отчество"
                                                    placeholder="Введите отчество"
                                                    :messages="$errors->get('patronymic')"/>

                                <x-input-with-label type="email"
                                                    name="email"
                                                    :value="old('email') ?? $user->email"
                                                    label="Эл.почта"
                                                    placeholder="Введите эл.почту"
                                                    :messages="$errors->get('email')"
                                                    required/>

                                <x-input-with-label name="phone_number"
                                                    :value="old('phone_number') ?? $user->phone_number"
                                                    label="Моб.телефон"
                                                    placeholder="Введите моб.телефон"
                                                    :messages="$errors->get('phone_number')"
                                                    data-inputmask="&quot;mask&quot;: &quot;9(999)999-9999&quot;"
                                                    data-mask=""
                                                    inputmode="text"/>

                                <x-select name="gender" label="Пол">
                                    @foreach($genders as $gender)
                                        <option @selected($user->getGender() == $gender)
                                                @selected(old('gender') == $gender)
                                                value="{{ $gender }}">
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </x-select>

                                <x-input-file name="image"
                                              label="Изображение"
                                              placeholder="Загрузить изображение"
                                              help="Размер {{ $imgParams['width'] }}x{{ $imgParams['height'] }} px, не более {{ $imgParams['maximum_size'] }} Kb"
                                              :messages="$errors->get('image')"/>

                                <x-input-checkbox name="delete_image" label="Удалить изображение"
                                                  disabled="{{ !$user->hasImage() }}"/>

                                @if($user->hasImage())
                                    <img src="{{ $user->getImageUrl() }}" alt="user image">
                                @endif

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Сохранить изменения</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
