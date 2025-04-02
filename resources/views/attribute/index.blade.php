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

                                                        <x-input-with-label label="Наименование"
                                                                            name="updatedTitle"
                                                                            value="{{ $errors->first('attributeIdError') === $attribute->id
                                                                            ? old('updatedTitle') : $attribute->title }}"
                                                                            placeholder="Введите наименование атрибута"
                                                                            :messages="$errors->first('attributeIdError') === $attribute->id
                                                                            ? $errors->get('updatedTitle') : null"
                                                                            required/>

                                                        <x-select name="updatedMeasureUnitId"
                                                                  label="Единица измерения"
                                                                  :messages="$errors->first('attributeIdError') === $attribute->id
                                                                            ? $errors->get('updatedMeasureUnitId') : null">
                                                            <option value="" selected>-</option>
                                                            @foreach($measureUnits as $measureUnit)
                                                                <option value="{{ $measureUnit->id }}"
                                                                        @selected($attribute->measure_unit_id === $measureUnit->id ||
                    ($errors->first('attributeIdError') === $attribute->id && (int)old('updatedMeasureUnitId') === $measureUnit->id))>{{ $measureUnit->title }}</option>
                                                            @endforeach
                                                        </x-select>

                                                        <x-input-with-label name="updatedNewMeasureUnit"
                                                                            placeholder="Создать новую единицу измерения"
                                                                            :messages="$errors->first('attributeIdError') === $attribute->id
                                                                            ? $errors->get('updatedNewMeasureUnit') : null"/>
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

                                        <x-input-with-label label="Наименование"
                                                            name="title"
                                                            placeholder="Введите наименование атрибута"
                                                            :messages="$errors->get('title')"
                                                            required/>

                                        <x-select name="measureUnitId"
                                                  label="Единица измерения"
                                                  :messages="$errors->get('measureUnitId')">
                                            <option value="" selected>-</option>
                                            @foreach($measureUnits as $measureUnit)
                                                <option value="{{ $measureUnit->id }}"
                                                        @selected((int)old('measureUnitId') === $measureUnit->id)>{{ $measureUnit->title }}</option>
                                            @endforeach
                                        </x-select>

                                        <x-input-with-label name="newMeasureUnit"
                                                            placeholder="Создать новую единицу измерения"
                                                            :messages="$errors->get('newMeasureUnit')"/>

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

    @pushIf($errors->has('title') || $errors->has('measureUnitId') || $errors->has('newMeasureUnit'), 'scripts')
        <script>
            $('#modal-create-attribute').modal('show');
        </script>
    @endpushIf

    @pushIf($errors->has('attributeIdError'), 'scripts')
        <script>
            let attributeId = @json($errors->first('attributeIdError'));
            console.log(attributeId)
            $(`#modal-edit-attribute${attributeId}`).modal('show');
        </script>
    @endpushIf
</x-app-layout>
