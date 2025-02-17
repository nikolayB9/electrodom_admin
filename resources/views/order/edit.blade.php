<x-app-layout>
    <x-content-header pageTitle="Заказ № {{ $order->id }}">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Заказы</a></li>
        <li class="breadcrumb-item active">№ {{ $order->id }}</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">

                    <div class="mb-3 d-flex">

                        <!-- Button trigger modal delete user -->
                        <button class="btn btn-danger mr-2"
                                data-toggle="modal"
                                data-target="#modal-delete-user{{ $order->id }}">
                            Удалить заказ
                        </button>
                    </div>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    <!-- User -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Редактировать</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('orders.update', $order->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="text-bold">ID</td>
                                        <td>{{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Покупатель</td>
                                        <td><a href="{{ route('users.edit', $order->user->id) }}">
                                                {{ $order->user->getFullName() }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Статус</td>
                                        <td>{{ $order->getStatusName() }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Состав заказа</td>
                                        <td>
                                            @foreach($order->products as $product)
                                                <div>
                                                    <a href="{{ route('products.edit', $product->id) }}">
                                                        {{ $product->id . '.' . $product->title }}
                                                    </a>
                                                </div>
                                                <div class="text-right">
                                                    x {{ $product->pivot->qty }} = {{ $product->pivot->total_price }} ₽
                                                </div>
                                            @endforeach
                                            <div class="d-flex justify-content-between my-2">
                                                <div>Купон:</div>
                                                <div>- {{ $order->coupon }} ₽</div>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <div>Доставка:</div>
                                                <div>+ {{ $order->shipping }} ₽</div>
                                            </div>
                                            <div class="d-flex justify-content-between h4">
                                                <div>Итого:</div>
                                                <div>= {{ $order->total_price }} ₽</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Адрес доставки</td>
                                        <td>{{ $order->getFullAddress() }}</td>
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

                    <!-- Modal delete user -->
                    <div class="modal fade" id="modal-delete-user{{ $order->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Удалить заказ № {{ $order->id }}?

                                    </h5>
                                </div>

                                <form action="{{ route('orders.destroy', $order->id) }}"
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
