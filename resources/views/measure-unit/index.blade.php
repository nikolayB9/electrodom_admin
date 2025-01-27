<x-app-layout>
    <x-content-header pageTitle="Единицы измерения">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('attributes.index') }}">Атрибуты</a></li>
        <li class="breadcrumb-item active">Единицы измерения</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mb-3">

                    <!-- Button trigger modal create measure unit -->
                    <button class="btn btn-primary mb-3"
                            data-toggle="modal"
                            data-target="#modal-create-measure-unit">
                        Добавить единицу измерения
                    </button>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    @if(!empty($errors->get('measureUnitDeletion')))
                        <x-alert-danger :messages="$errors->get('measureUnitDeletion')"/>
                    @endif

                    @if(!empty($errors->get('title')))
                        <x-alert-danger :messages="$errors->get('title')"/>
                    @endif

                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($measureUnits as $measureUnit)
                                    <tr>
                                        <td style="width: 10px; padding-right: 0;">
                                            {{ $measureUnit->id  }}.
                                        </td>
                                        <td>
                                            {{ $measureUnit->title }}
                                        </td>
                                        <td>
                                            <!-- Button trigger modal edit measure unit -->
                                            <button class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal-edit-measure-unit{{ $measureUnit->id }}">
                                                Редактировать
                                            </button>

                                            <!-- Button trigger modal delete measure unit -->
                                            <button class="btn btn-danger btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal-delete-measure-unit{{ $measureUnit->id }}">
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal edit measure unit -->
                                    <div class="modal fade" id="modal-edit-measure-unit{{ $measureUnit->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Редактировать единицу измерения
                                                        "{{ $measureUnit->title }}"
                                                    </h5>
                                                </div>

                                                <form action="{{ route('measure-units.update', $measureUnit->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="modal-body">
                                                        <x-input-with-label
                                                            name="title"
                                                            :value="$measureUnit->title"
                                                            placeholder="Введите название единицы измерения"
                                                            required/>
                                                    </div>

                                                    <div class="modal-footer justify-content-end">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            Отмена
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Сохранить
                                                            изменения
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                    <!-- Modal delete measure unit -->
                                    <div class="modal fade" id="modal-delete-measure-unit{{ $measureUnit->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Удалить единицу измерения
                                                        "{{ $measureUnit->title }}" ?
                                                    </h5>
                                                </div>

                                                <form action="{{ route('measure-units.destroy', $measureUnit->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="modal-body">
                                                        <div class="mb-3 text-sm">
                                                            Если единица измерения принадлежит хотя бы одному атрибуту,
                                                            ее нельзя удалить.
                                                        </div>
                                                    </div>

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
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <!-- Modal create measure unit -->
                    <div class="modal fade" id="modal-create-measure-unit">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Добавить единицу измерения</h5>
                                </div>

                                <form action="{{ route('measure-units.store') }}"
                                      method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <x-input-with-label
                                            name="title"
                                            value=""
                                            placeholder="Введите название единицы измерения"
                                            required/>
                                    </div>

                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                            Отмена
                                        </button>
                                        <button type="submit" class="btn btn-primary">Добавить</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
