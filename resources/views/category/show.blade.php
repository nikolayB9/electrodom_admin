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
                <div class="col-md-5">

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    <div class="mb-2">
                        <img
                            src="{{ $category->getImageUrl() ??  asset('assets/img/default-category-160x160.png')}}"
                            alt="preview image">
                    </div>


                    <div class="mb-2 d-flex">
                        <a href="{{ route('categories.edit', $category->id) }}"
                           type="button"
                           class="btn btn-flat btn-primary mr-2">Редактировать</a>

                        <!-- Button trigger modal delete category -->
                        <button type="button"
                                class="btn btn-flat btn-danger"
                                data-toggle="modal"
                                data-target="#modal-delete-category">
                            Удалить
                        </button>
                    </div>

                    <div class="mb-3">
                        <!-- Button trigger modal edit attributes -->
                        <button type="button"
                                class="btn btn-flat btn-primary"
                                data-toggle="modal"
                                data-target="#modal-edit-attributes">
                            Добавить / Удалить атрибуты
                        </button>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Атрибуты категории</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Update software</td>
                        </tr>
                        <tr>
                            <td>Clean database</td>
                        </tr>
                        </tbody>
                    </table>

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

                    <!-- Modal edit attributes -->
                    {{--<div class="modal fade" id="modal-edit-attributes">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Добавить/удалить атрибуты у категории "{{ $category->title }}"
                                    </h5>
                                </div>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="text-sm">
                                            При удалении атрибута он не удаляется у
                                            дочерних категорий.
                                        </div>
                                        <div class="mb-3 text-sm">
                                            При добавлении атрибута он добавится и у
                                            дочерних категорий.
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
                    </div>--}}
                    <!-- /.modal -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
