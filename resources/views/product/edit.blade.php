<x-app-layout>
    <x-content-header pageTitle="Продукт '{{ $product->title }}'">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Продукты</a></li>
        <li class="breadcrumb-item active">{{ $product->title }}</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">

                    <div class="mb-3 d-flex">

                        <!-- Button trigger modal delete product -->
                        <button class="btn btn-danger"
                                data-toggle="modal"
                                data-target="#modal-delete-product{{ $product->id }}">
                            Удалить продукт
                        </button>
                    </div>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    @if(!empty($errors->get('attributes_ids')))
                        <x-alert-danger :messages="$errors->get('attributes_ids')"/>
                    @endif

                    <!-- Product -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактировать</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('products.update', $product->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="text-bold">ID</td>
                                        <td>{{ $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Наименование</td>
                                        <td>
                                            <x-input-with-label name="title"
                                                                :value="old('title') ?? $product->title"
                                                                placeholder="Наименование продукта"
                                                                :messages="$errors->get('title')"
                                                                required/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Описание</td>
                                        <td>
                                            <x-textarea name="description"
                                                        rows="10"
                                                        placeholder="Описание продукта"
                                                        :text="$product->description"
                                                        :messages="$errors->get('description')"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Цена</td>
                                        <td>
                                            <x-input-with-label type="number"
                                                                name="price"
                                                                :value="old('price') ?? $product->price"
                                                                placeholder="Цена"
                                                                :messages="$errors->get('price')"
                                                                step="0.01"
                                                                min="0"
                                                                required/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Старая цена</td>
                                        <td>
                                            <x-input-with-label type="number"
                                                                name="old_price"
                                                                :value="old('old_price') ?? $product->old_price"
                                                                placeholder="Старая цена"
                                                                :messages="$errors->get('old_price')"
                                                                step="0.01"
                                                                min="0"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Количество в наличии</td>
                                        <td>
                                            <x-input-with-label type="number"
                                                                name="count"
                                                                :value="old('count') ?? $product->count"
                                                                placeholder="Количество в наличии"
                                                                :messages="$errors->get('count')"
                                                                min="0"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Категория</td>
                                        <td>
                                            <x-select name="category_id"
                                                      :messages="$errors->get('category_id')">
                                                @foreach($categories as $category)
                                                    <option
                                                            value="{{ $category->id }}" @selected(old('category_id') == $category->id || $product->category_id == $category->id)>
                                                        {{ $category->title }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Изображение</td>
                                        <td>
                                            @if($product->hasImage())
                                                <img src="{{ $product->getImageUrl() }}" alt="product image"
                                                     class="mb-3">
                                            @endif

                                            <x-input-file name="image"
                                                          placeholder="{{ $product->hasImage() ? 'Новое изображение' : 'Изображение' }}"
                                                          help="Размер {{ $imgParams['width'] }}x{{ $imgParams['height'] }} px, не более {{ $imgParams['maximum_size'] }} Kb"
                                                          :messages="$errors->get('image')"/>

                                            <x-input-checkbox name="delete_image" label="Удалить изображение"
                                                              disabled="{{ !$product->hasImage() }}"/>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Опубликовать</td>
                                        <td>
                                            <x-input-checkbox name="is_published"
                                                              checked="{{ (bool)$product->is_published }}"
                                                              class="icheck-primary"
                                                              label=""/>
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

                    <!-- Attributes -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактировать атрибуты продукта</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('products.update_attributes', $product->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body pb-0 login-card-body">
                                @foreach($attributes as $attribute)
                                    <div class="form-group">
                                        <label for="attribute{{ $attribute->id }}"
                                               class="mb-1 font-weight-normal"
                                               style="color: #000;">
                                            {{ $attribute->fullTitle }}
                                        </label>
                                        <input type="text"
                                               class="form-control {{ !empty($errors->updatePassword->get("attributes_ids[$attribute->id]")) ? 'is-invalid' : '' }}"
                                               name="attributes_ids[{{ $attribute->id }}]"
                                               value="{{ $attribute->value }}"
                                               id="attribute{{ $attribute->id }}"
                                               placeholder="Введите значение атрибута">
                                        {{--                                        <x-input-error :messages="{{ $errors->updatePassword->get("attributes_ids[$attribute->id]") }}"/>--}}
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- Modal delete product -->
                    <div class="modal fade" id="modal-delete-product{{ $product->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Удалить продукт
                                        "{{ $product->title }}" ?
                                    </h5>
                                </div>

                                <form action="{{ route('products.destroy', $product->id) }}"
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
