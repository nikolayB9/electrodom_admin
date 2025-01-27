<x-app-layout>
    <x-content-header pageTitle="Продукты">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item active">Продукты</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-3">

                    <a href="{{ route('products.create') }}"
                       type="button"
                       class="btn btn-primary mb-3">
                        Добавить продукт
                    </a>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    @if(!empty($errors->get('categoryDeletion')))
                        <x-alert-danger :messages="$errors->get('categoryDeletion')"/>
                    @endif

                    <div class="card">
                        <div class="card-header">


                            <div class="input-group input-group-sm float-right" style="width: 400px; height: 46px;">
                                <input style=height:46px;" type="text" name="table_search" class="form-control float-right"
                                       placeholder="Поиск продукта по названию">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Цена</th>
                                    <th>Категория</th>
                                    <th>Изображение</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}.</td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                               class="text-body">
                                                {{ $product->title }}
                                            </a>
                                        </td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $product->category->id) }}"
                                               class="text-body">
                                                {{ $product->category->title }}
                                            </a>
                                        </td>
                                        <td>
                                            <img src="{{ $product->getImageUrl() }}" alt="product image" style="width: 100px;">
                                        </td>
                                        <td class="d-flex"> <a href="{{ route('products.edit', $product->id) }}"
                                                type="button"
                                                class="btn btn-primary btn-sm mr-2">
                                                Редактировать
                                            </a>
                                            <!-- Button trigger modal delete product -->
                                            <button class="btn btn-danger btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal-delete-product{{ $product->id }}">
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
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
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
