<x-app-layout>
    <x-content-header pageTitle="Редактировать категорию '{{ $category->title }}'">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Категории</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.show', $category->id) }}">{{ $category->title }}</a></li>
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
                        <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <x-input-with-label name="title"
                                                    :value="old('title') ?? $category->title"
                                                    label="Наименование"
                                                    placeholder="Введите наименование категории"
                                                    :messages="$errors->get('title')"
                                                    required/>

                                <div class="form-group">
                                    <label for="parent_category" class="mb-1">Выбрать родительскую категорию</label>
                                    <select class="custom-select @error('parent_category') is-invalid @enderror"
                                            name="parent_category"
                                            id="parent_category"
                                            aria-describedby="parent_category_help">
                                        <option value="">-</option>
                                        @foreach($categories as $parentCategory)
                                            <option value="{{ $parentCategory->id }}"
                                                @selected($parentCategoryId == $parentCategory->id)
                                                @selected(old('parent_category') == $parentCategory->id)>

                                                @for ($i = $parentCategory->level; $i > 0; $i--)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                @endfor
                                                {{ $parentCategory->title }}

                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('parent_category')"/>
                                    <small id="parent_category_help" class="form-text text-muted">При выборе
                                        родительской категории
                                        наследуются все ее атрибуты.</small>
                                </div>

                                <div class="form-group">
                                    <label for="previous_category" class="mb-1">Место в списке (после какой
                                        категории)</label>
                                    <select class="custom-select @error('previous_category') is-invalid @enderror"
                                            name="previous_category"
                                            id="previous_category"
                                            aria-describedby="previous_category_help">
                                        <option value="">В начало списка</option>
                                        @foreach($categories as $previousCategory)
                                            <option value="{{ $previousCategory->id }}"
                                                @selected($previousCategoryId == $previousCategory->id)
                                                @selected(old('previous_category') == $previousCategory->id)>

                                                @for ($i = $previousCategory->level; $i > 0; $i--)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                @endfor
                                                {{ $previousCategory->title }}

                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('previous_category')"/>
                                    <small id="previous_category_help" class="form-text text-muted">Выбираемая категория
                                        должна быть
                                        потомком выбранной родительской категории.</small>
                                </div>

                                <x-input-file name="image"
                                              placeholder="Изображение категории"
                                              help="Размер {{ $imgParams['width'] }}x{{ $imgParams['height'] }} px, не более {{ $imgParams['maximum_size'] }} Kb"
                                              :messages="$errors->get('image')"/>

                                <x-input-checkbox name="delete_image" label="Удалить изображение"
                                                  disabled="{{ empty($category->getImageUrl()) }}"/>

                                @if(!empty($category->getImageUrl()))
                                    <img src="{{ $category->getImageUrl() }}" alt="category image">
                                @endif

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
