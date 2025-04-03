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
                            <form action="{{ route('products.index') }}" method="get">
                                <div class="input-group input-group-sm float-right" style="width: 400px; height: 46px;">
                                    @foreach($get as $name => $value)
                                        @if($name !== 'title')
                                            <input name="{{ $name }}"
                                                   value="{{ $value }}"
                                                   type="hidden">
                                        @endif
                                    @endforeach
                                    <input style=height:46px;"
                                           type="text"
                                           name="title"
                                           value="{{ request()->get('title') }}"
                                           class="form-control float-right"
                                           placeholder="Поиск продукта по названию">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form><!-- /.search by title -->

                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-default ml-3">Удалить фильтры</a>
                        </div><!-- /.card-header -->

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">ID</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('products.index') }}" method="get">
                                                    @foreach($get as $name => $value)
                                                        @if($name !== 'orderBy')
                                                            <input name="{{ $name }}"
                                                                   value="{{ $value }}"
                                                                   type="hidden">
                                                        @endif
                                                    @endforeach
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Product\OrderByEnum::ID_ASC->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\Product\OrderByEnum::getDescription(\App\Enums\Product\OrderByEnum::ID_ASC) }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('products.index') }}" method="get">
                                                    @foreach($get as $name => $value)
                                                        @if($name !== 'orderBy')
                                                            <input name="{{ $name }}"
                                                                   value="{{ $value }}"
                                                                   type="hidden">
                                                        @endif
                                                    @endforeach
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Product\OrderByEnum::ID_DESC->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\Product\OrderByEnum::getDescription(\App\Enums\Product\OrderByEnum::ID_DESC) }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by ID -->
                                    </th>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">Наименование</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('products.index') }}" method="get">
                                                    @foreach($get as $name => $value)
                                                        @if($name !== 'orderBy')
                                                            <input name="{{ $name }}"
                                                                   value="{{ $value }}"
                                                                   type="hidden">
                                                        @endif
                                                    @endforeach
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Product\OrderByEnum::NAME_A_Z->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\Product\OrderByEnum::getDescription(\App\Enums\Product\OrderByEnum::NAME_A_Z) }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('products.index') }}" method="get">
                                                    @foreach($get as $name => $value)
                                                        @if($name !== 'orderBy')
                                                            <input name="{{ $name }}"
                                                                   value="{{ $value }}"
                                                                   type="hidden">
                                                        @endif
                                                    @endforeach
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Product\OrderByEnum::NAME_Z_A->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\Product\OrderByEnum::getDescription(\App\Enums\Product\OrderByEnum::NAME_Z_A) }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by Title -->
                                    </th>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">Цена</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('products.index') }}" method="get">
                                                    @foreach($get as $name => $value)
                                                        @if($name !== 'orderBy')
                                                            <input name="{{ $name }}"
                                                                   value="{{ $value }}"
                                                                   type="hidden">
                                                        @endif
                                                    @endforeach
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Product\OrderByEnum::PRICE_LOW_HIGH->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\Product\OrderByEnum::getDescription(\App\Enums\Product\OrderByEnum::PRICE_LOW_HIGH) }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('products.index') }}" method="get">
                                                    @foreach($get as $name => $value)
                                                        @if($name !== 'orderBy')
                                                            <input name="{{ $name }}"
                                                                   value="{{ $value }}"
                                                                   type="hidden">
                                                        @endif
                                                    @endforeach
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Product\OrderByEnum::PRICE_HIGH_LOW->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">
                                                        {{ \App\Enums\Product\OrderByEnum::getDescription(\App\Enums\Product\OrderByEnum::PRICE_HIGH_LOW) }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by Price -->
                                    </th>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">Категория</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="z-index: 10000;">
                                                @foreach($categories as $category)
                                                    <form action="{{ route('products.index') }}" method="get">
                                                        @foreach($get as $name => $value)
                                                            @if($name !== 'categoryId')
                                                                <input name="{{ $name }}"
                                                                       value="{{ $value }}"
                                                                       type="hidden">
                                                            @endif
                                                        @endforeach
                                                        <input name="categoryId"
                                                               value="{{ $category->id }}"
                                                               type="hidden">
                                                        <button type="submit"
                                                                class="dropdown-item">{{ $category->title }}</button>
                                                    </form>
                                                @endforeach
                                            </div>
                                        </div><!-- /.order by Category -->
                                    </th>
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
                                            <img src="{{ $product->getImageUrl() }}" alt="product image"
                                                 style="width: 100px;">
                                        </td>
                                        <td class="d-flex"><a href="{{ route('products.edit', $product->id) }}"
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

                        <div class="card-footer clearfix">
                            {{ $products->onEachSide(2)->withQueryString()->links() }}
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
