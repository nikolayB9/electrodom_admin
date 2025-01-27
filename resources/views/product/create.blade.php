<x-app-layout>
    <x-content-header pageTitle="Добавить продукт">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Продукты</a></li>
        <li class="breadcrumb-item active">Добавить</li>
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
                            <h3 class="card-title">Заполните поля</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <x-input-with-label name="title"
                                                    label="Наименование"
                                                    placeholder="Введите наименование продукта"
                                                    :messages="$errors->get('title')"
                                                    required/>

                                <x-input-with-label name="description"
                                                    label="Описание"
                                                    placeholder="Введите описание продукта"
                                                    :messages="$errors->get('description')"/>

                                <x-input-with-label type="number"
                                                    name="price"
                                                    :value="old('price') ?? 0"
                                                    label="Цена"
                                                    placeholder="Введите цену продукта"
                                                    :messages="$errors->get('price')"
                                                    step="0.01"
                                                    min="0"
                                                    required/>

                                <x-input-with-label type="number"
                                                    name="count"
                                                    :value="old('count') ?? 0"
                                                    label="Количество в наличии"
                                                    placeholder="Введите количество"
                                                    :messages="$errors->get('count')"
                                                    min="0"/>

                                <x-select name="category_id"
                                          label="Категория"
                                          :messages="$errors->get('category_id')">
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </x-select>

                                <x-input-file name="image"
                                              label="Изображение продукта"
                                              placeholder="Выберите изображение"
                                              help="Размер {{ $imgParams['width'] }}x{{ $imgParams['height'] }} px, не более {{ $imgParams['maximum_size'] }} Kb"
                                              :messages="$errors->get('image')"/>

                                <x-input-checkbox name="is_published"
                                                  checked="true"
                                                  class="icheck-primary"
                                                  label="Опубликовать"/>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Добавить</button>
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
