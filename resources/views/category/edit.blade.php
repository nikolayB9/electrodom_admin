<x-app-layout>
    <x-content-header pageTitle="Категория '{{ $category->title }}'">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Категории</a></li>
        <li class="breadcrumb-item active">{{ $category->title }}</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">

                    <!-- Button trigger modal delete category -->
                    <button type="button"
                            class="btn btn-danger mb-3"
                            data-toggle="modal"
                            data-target="#modal-delete-category">
                        Удалить категорию
                    </button>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    @if(!empty($errors->get('attributes_ids')))
                        <x-alert-danger :messages="$errors->get('attributes_ids')"/>
                    @endif

                    @if(!empty($errors->get('categoryDeletion')))
                        <x-alert-danger :messages="$errors->get('categoryDeletion')"/>
                    @endif

                    <!-- Category -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактировать</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('categories.update', $category->id) }}" method="post"
                              enctype="multipart/form-data">
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
                                    <label for="parent_category" class="mb-1">Родительская категория</label>
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

                                    <a class="text-muted text-decoration"
                                       style="font-size: 80%"
                                       href="#parent-category-limitations"
                                       data-toggle="collapse"
                                       aria-expanded="false"
                                       aria-controls="parent-category-limitations">
                                        <u>Ограничения для родительской категории</u>
                                    </a>

                                    <div class="collapse" id="parent-category-limitations">
                                        <small class="form-text text-muted">Уровень вложенности
                                            родительской категории должен быть меньше чем у текущей категории.</small>
                                        <small class="form-text text-muted">При смене
                                            родительской категории
                                            к текущей категории и ее потомкам добавятся унаследованные атрибуты.</small>
                                        <small class="form-text text-muted">Родительскую категорию
                                            можно сменить только если к текущей категории или ее потомкам не относится
                                            ни
                                            один
                                            продукт.</small>
                                    </div>
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

                                @if($category->hasImage())
                                    <img src="{{ $category->getImageUrl() }}" alt="category image" class="mb-2">
                                @endif

                                <x-input-checkbox name="delete_image" label="Удалить изображение"
                                                  disabled="{{ !$category->hasImage() }}"/>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Сохранить</button>
                            </div>
                        </form>
                        <!-- /.form -->
                    </div>
                    <!-- /.card -->

                    <!-- Attributes -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактировать атрибуты категории</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('categories.update.attributes', $category->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body pb-0 login-card-body">

                                <a class="text-muted text-decoration"
                                   style="font-size: 80%"
                                   href="#attributes-limitations"
                                   data-toggle="collapse"
                                   aria-expanded="false"
                                   aria-controls="attributes-limitations">
                                    <u>Ограничения для редактирования атрибутов</u>
                                </a>

                                <div class="collapse" id="attributes-limitations">
                                    <small class="form-text text-muted">При удалении атрибута он не удаляется у
                                        дочерних категорий.</small>
                                    <small class="form-text text-muted">При добавлении атрибута он добавится и у
                                        дочерних категорий.</small>
                                    <small class="form-text text-muted">При удалении атрибута у категории с продуктами
                                        он удалится и у продуктов.</small>
                                    <small class="form-text text-muted">При добавлении атрибута у категории с продуктами
                                        он добавится и у продуктов.</small>
                                </div>

                                <ul class="list-unstyled card-columns mt-3" style="column-count: 2;">
                                    @foreach($attributes as $attribute)
                                        <li>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox"
                                                           name="attributes_ids[{{ $attribute->id }}]"
                                                           value="{{ $attribute->id }}"
                                                           id="check{{ $attribute->id }}"
                                                           @if(in_array($attribute->id, $categoryAttributesIds))
                                                               checked
                                                           @endif
                                                           @if(in_array($attribute->id, $parentAttributesIds))
                                                               disabled
                                                        @endif>
                                                    <label class="form-check-label"
                                                           for="check{{ $attribute->id }}">
                                                        {{ $attribute->fullTitle }}
                                                    </label>
                                                </div>

                                                @if(in_array($attribute->id, $parentAttributesIds))
                                                    <input type="hidden"
                                                           name="attributes_ids[{{ $attribute->id }}]"
                                                           value="{{ $attribute->id }}">
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- Modal delete category -->
                    <div class="modal fade" id="modal-delete-category">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Удалить категорию "{{ $category->title }}"?</h5>
                                </div>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-body">
                                        <div class="mb-3 text-sm">
                                            Если к категории (или ее подкатегориям) относятся продукты, ее
                                            нельзя удалить.
                                        </div>
                                        <div class="mb-3 text-sm">
                                            При удалении родительской категории ее подкатегории встанут на уровень выше.
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена
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
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
