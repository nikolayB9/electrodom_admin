<x-app-layout>
    <x-content-header pageTitle="Пользователь '{{ $user->getFullName() }}'">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Пользователи</a></li>
        <li class="breadcrumb-item active">{{ $user->getFullName() }}</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">

                    <div class="mb-3 d-flex">

                        <!-- Button trigger modal delete user -->
                        <button class="btn btn-danger mr-2"
                                data-toggle="modal"
                                data-target="#modal-delete-user{{ $user->id }}">
                            Удалить пользователя
                        </button>

                        <a href="{{ route('orders.index', ['userId' => $user->id]) }}" class="btn btn-primary">
                            Заказы пользователя
                        </a>
                    </div>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    <!-- User -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактировать</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('users.update', $user->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="text-bold">ID</td>
                                        <td>{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Роль</td>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Имя</td>
                                        <td>
                                            <x-input-with-label name="name"
                                                                :value="old('name') ?? $user->name"
                                                                placeholder="Имя"
                                                                :messages="$errors->get('name')"
                                                                required/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Фамилия</td>
                                        <td>
                                            <x-input-with-label name="surname"
                                                                :value="old('surname') ?? $user->surname"
                                                                placeholder="Фамилия"
                                                                :messages="$errors->get('surname')"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Отчество</td>
                                        <td>
                                            <x-input-with-label name="patronymic"
                                                                :value="old('patronymic') ?? $user->patronymic"
                                                                placeholder="Отчество"
                                                                :messages="$errors->get('patronymic')"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Пол</td>
                                        <td>
                                            <x-select name="gender">
                                                @foreach($genders as $gender)
                                                    <option @selected($user->getGender() == $gender)
                                                            @selected(old('gender') == $gender)
                                                            value="{{ $gender }}">
                                                        {{ $gender }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Email</td>
                                        <td>
                                            <x-input-with-label name="email"
                                                                :value="old('email') ?? $user->email"
                                                                placeholder="Email пользователя"
                                                                :messages="$errors->get('email')"
                                                                required/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Моб.телефон</td>
                                        <td>
                                            <x-input-with-label name="phone_number"
                                                                :value="old('phone_number') ?? $user->phone_number"
                                                                placeholder="Моб.телефон"
                                                                :messages="$errors->get('phone_number')"
                                                                data-inputmask="&quot;mask&quot;: &quot;9(999)9999999&quot;"
                                                                data-mask=""
                                                                inputmode="text"
                                                                required/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Адрес</td>
                                        <td>

                                            <label for="city" class="mb-1 font-weight-normal">Город</label>
                                            <x-input-with-label name="address[city]"
                                                                :value="$address->city ?? null"
                                                                placeholder="Город"
                                                                :messages="$errors->get('city')"/>

                                            <label for="street" class="mb-1 font-weight-normal">Улица</label>
                                            <x-input-with-label name="address[street]"
                                                                :value="$address->street ?? null"
                                                                placeholder="Улица"
                                                                :messages="$errors->get('street')"/>

                                            <label for="house" class="mb-1 font-weight-normal">Дом</label>
                                            <x-input-with-label name="address[house]"
                                                                :value="$address->house ?? null"
                                                                placeholder="Дом"
                                                                :messages="$errors->get('house')"/>

                                            <label for="flat" class="mb-1 font-weight-normal">Квартира</label>
                                            <x-input-with-label name="address[flat]"
                                                                :value="$address->flat ?? null"
                                                                placeholder="Квартира"
                                                                :messages="$errors->get('flat')"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Сохранить</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal delete user -->
                    <div class="modal fade" id="modal-delete-user{{ $user->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Удалить пользователя
                                        "{{ $user->getFullName() . '; id = ' . $user->id . '; email = ' . $user->email }}
                                        " ?
                                    </h5>
                                </div>

                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Отмена
                                        </button>
                                        <button type="submit" class="btn btn-danger">Удалить</button>
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
