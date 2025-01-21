<x-app-layout>
    <x-content-header pageTitle="Редактировать атрибут '{{ $attribute->fullTitle() }}'">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('attributes.index') }}">Атрибуты</a></li>
        <li class="breadcrumb-item active">{{ $attribute->fullTitle() }}</li>
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
                        <form action="{{ route('attributes.update', $attribute->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <x-input-with-label name="title"
                                                    :value="old('title') ?? $attribute->title"
                                                    label="Наименование"
                                                    placeholder="Введите наименование атрибута"
                                                    :messages="$errors->get('title')"
                                                    required/>

                                <div class="form-group">
                                    <label for="measure_unit_id" class="mb-1">Единица измерения</label>
                                    <select class="custom-select  {{ !empty($errors->get('measure_unit_id')) ? 'is-invalid' : '' }}"
                                            name="measure_unit_id"
                                            id="measure_unit_id">
                                        <option value="" selected>-</option>
                                        @foreach($measureUnits as $measureUnit)
                                            <option value="{{ $measureUnit->id }}"
                                                    @selected(old('measure_unit_id') == $measureUnit->id)
                                                    @selected($attribute->measureUnitId() == $measureUnit->id)>
                                                {{ $measureUnit->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('measure_unit_id')"/>
                                </div>

                                <x-input-with-label name="new_measure_unit"
                                                    placeholder="Создать новую единицу измерения"
                                                    :messages="$errors->get('new_measure_unit')"/>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Сохранить изменения</button>
                            </div>
                        </form>
                        <!-- /.form -->
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
