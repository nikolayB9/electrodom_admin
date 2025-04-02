<x-app-layout>
    <x-content-header pageTitle="Атрибуты">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item active">Атрибуты</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mb-3">

                    <!-- Button trigger modal create attribute -->
                    <button class="btn btn-primary mb-3 mr-2"
                            type="button"
                            data-toggle="modal"
                            data-target="#modal-create-attribute">
                        Добавить атрибут
                    </button>

                    <a href="{{ route('measure-units.index') }}"
                       type="button"
                       class="btn btn-primary mb-3">
                        Единицы измерения
                    </a>

                    @if (session('success'))
                        <x-alert-success :message="session('success')"/>
                    @endif

                    @if (session('error'))
                        <x-alert-danger :message="session('error')"/>
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
                                @foreach($attributes as $attribute)
                                    <tr>
                                        <td style="width: 10px; padding-right: 0;">
                                            {{ $attribute->id }}.
                                        </td>
                                        <td>
                                            {{ $attribute->fullTitle }}
                                        </td>
                                        <td>
                                            <!-- Button trigger modal edit attribute -->
                                            <button class="btn btn-primary btn-sm mr-2"
                                                    data-toggle="modal"
                                                    data-target="#modal-edit-attribute{{ $attribute->id }}">
                                                Редактировать
                                            </button>

                                            <!-- Button trigger modal delete attribute -->
                                            <button class="btn btn-danger btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal-delete-attribute{{ $attribute->id }}">
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal edit attribute -->
                                    <div class="modal fade" id="modal-edit-attribute{{ $attribute->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Редактировать атрибут
                                                        "{{ $attribute->fullTitle }}"
                                                    </h5>
                                                </div>

                                                <form action="{{ route('attributes.update', $attribute->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="modal-body">

                                                        <x-input-with-label name="title"
                                                                            :value="$attribute->title"
                                                                            label="Наименование"
                                                                            placeholder="Введите наименование атрибута"
                                                                            required/>

                                                        <x-select name="measure_unit_id"
                                                                  label="Единица измерения">
                                                            <option value="" selected>-</option>
                                                            @foreach($measureUnits as $measureUnit)
                                                                <option value="{{ $measureUnit->id }}"
                                                                    @selected($measureUnit->id == $attribute->measureUnitId)>
                                                                    {{ $measureUnit->title }}
                                                                </option>
                                                            @endforeach
                                                        </x-select>

                                                        <x-input-with-label name="new_measure_unit"
                                                                            value=""
                                                                            placeholder="Создать новую единицу измерения"/>

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

                                    <!-- Modal delete attribute -->
                                    <div class="modal fade" id="modal-delete-attribute{{ $attribute->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Удалить атрибут
                                                        "{{ $attribute->fullTitle }}" ?
                                                    </h5>
                                                </div>

                                                <form action="{{ route('attributes.destroy', $attribute->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="modal-body">
                                                        <div class="mb-3 text-sm">
                                                            Если атрибут принадлежит хотя бы одной категории, его нельзя
                                                            удалить.
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

                    <!-- Modal create attribute -->
                    <div class="modal fade" id="modal-create-attribute">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Добавить атрибут</h5>
                                </div>

                                <form action="{{ route('attributes.store') }}"
                                      method="post">
                                    @csrf
                                    <div class="modal-body">

                                        <x-input-with-label name="title"
                                                            value=""
                                                            label="Наименование"
                                                            placeholder="Введите наименование атрибута"
                                                            required/>

                                        <x-select name="measure_unit_id"
                                                  label="Единица измерения">
                                            <option value="" selected>-</option>
                                            @foreach($measureUnits as $measureUnit)
                                                <option value="{{ $measureUnit->id }}">
                                                    {{ $measureUnit->title }}
                                                </option>
                                            @endforeach
                                        </x-select>

                                        <x-input-with-label name="new_measure_unit"
                                                            value=""
                                                            placeholder="Создать новую единицу измерения"/>

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
