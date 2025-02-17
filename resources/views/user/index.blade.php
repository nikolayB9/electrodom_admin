<x-app-layout>
    <x-content-header pageTitle="Пользователи">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item active">Пользователи</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-3">

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    <div class="card">
                        <div class="card-header">

                            <form action="{{ route('users.index') }}" method="get">
                                <div class="input-group input-group-sm float-right" style="width: 400px; height: 46px;">
                                    <input style=height:46px;"
                                           type="text"
                                           name="nameOrEmail"
                                           value="{{ request()->get('nameOrEmail') }}"
                                           class="form-control float-right"
                                           placeholder="Поиск по имени или по email">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form><!-- /.search by name or email -->

                        </div><!-- /.card-header -->

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">ID</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('users.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\User\OrderByEnum::ID_ASC->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\User\OrderByEnum::getDescription(\App\Enums\User\OrderByEnum::ID_ASC) }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('users.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\User\OrderByEnum::ID_DESC->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\User\OrderByEnum::getDescription(\App\Enums\User\OrderByEnum::ID_DESC) }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by ID -->
                                    </th>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">Email</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('users.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\User\OrderByEnum::EMAIL_A_Z->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\User\OrderByEnum::getDescription(\App\Enums\User\OrderByEnum::EMAIL_A_Z) }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('users.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\User\OrderByEnum::EMAIL_Z_A->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\User\OrderByEnum::getDescription(\App\Enums\User\OrderByEnum::EMAIL_Z_A) }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by Email -->
                                    </th>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">Имя</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('users.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\User\OrderByEnum::NAME_A_Z->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\User\OrderByEnum::getDescription(\App\Enums\User\OrderByEnum::NAME_A_Z) }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('users.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\User\OrderByEnum::NAME_Z_A->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\User\OrderByEnum::getDescription(\App\Enums\User\OrderByEnum::NAME_Z_A) }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by Name -->
                                    </th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}.</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                               class="text-body">
                                                {{ $user->email }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                               class="text-body">
                                                {{ $user->getFullname() }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                               type="button"
                                               class="btn btn-primary btn-sm mr-2 mb-1">
                                                Редактировать
                                            </a>
                                            <!-- Button trigger modal delete user -->
                                            <button class="btn btn-danger btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal-delete-user{{ $user->id }}">
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
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
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
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
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $users->onEachSide(2)->withQueryString()->links() }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
