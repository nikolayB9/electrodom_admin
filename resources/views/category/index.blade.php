<x-app-layout>
    <x-content-header pageTitle="Категории">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item active">Категории</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-3">

                    <a href="{{ route('categories.create') }}"
                       type="button"
                       class="btn btn-primary mb-3">
                        Добавить категорию
                    </a>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    @if(!empty($errors->get('categoryDeletion')))
                        <x-alert-danger :messages="$errors->get('categoryDeletion')"/>
                    @endif

                    <ul class="list-unstyled">
                        @foreach($categories as $key => $category)
                            <li class="mb-1">
                                <span style="padding-left: {{ $category->level * 30 }}px;"></span>

                                <div class="btn-group dropright">
                                    <a type="button"
                                       href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-default">
                                        {{ $category->title }}
                                    </a>
                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                            data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>

                                    <div class="dropdown-menu" role="menu">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="dropdown-item">Редактировать</a>

                                        <div class="dropdown-divider"></div>
                                        <!-- Button trigger modal delete category -->
                                        <button class="dropdown-item"
                                                data-toggle="modal"
                                                data-target="#modal-delete-category{{ $category->id }}">
                                            Удалить
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal delete category -->
                                <div class="modal fade" id="modal-delete-category{{ $category->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Удалить категорию "{{ $category->title }}"
                                                    ?</h5>
                                            </div>

                                            <form action="{{ route('categories.destroy', $category->id) }}"
                                                  method="post">
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
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
