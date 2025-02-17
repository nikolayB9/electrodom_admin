<x-app-layout>
    <x-content-header pageTitle="Заказы">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item active">Заказы</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-3">

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <form action="{{ route('orders.index') }}" method="get">
                                <div class="input-group input-group-sm float-right" style="width: 400px; height: 46px;">
                                    <input style=height:46px;"
                                           type="text"
                                           name="date"
                                           value="{{ request()->get('date') }}"
                                           class="form-control float-right"
                                           placeholder="Поиск заказов по дате гггг-мм-дд">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form><!-- /.search by date -->
                        </div><!-- /.card-header -->

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">Дата</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('orders.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Order\OrderByEnum::DATE_NEW_OLD->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">{{ \App\Enums\Order\OrderByEnum::DATE_NEW_OLD->value }}</button>
                                                </form>
                                                <form action="{{ route('orders.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Order\OrderByEnum::DATE_OLD_NEW->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">{{ \App\Enums\Order\OrderByEnum::DATE_OLD_NEW->value }}</button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by Date -->
                                    </th>
                                    <th>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><span
                                                    class="text-bold">Стоимость</span></button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('orders.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Order\OrderByEnum::PRICE_L_H->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">{{ \App\Enums\Order\OrderByEnum::PRICE_L_H->value }}</button>
                                                </form>
                                                <form action="{{ route('orders.index') }}" method="get">
                                                    <input name="orderBy"
                                                           value="{{ \App\Enums\Order\OrderByEnum::PRICE_H_L->value }}"
                                                           type="hidden">
                                                    <button type="submit"
                                                            class="dropdown-item">{{ \App\Enums\Order\OrderByEnum::PRICE_H_L->value }}</button>
                                                </form>
                                            </div>
                                        </div><!-- /.order by totalPrice -->
                                    </th>
                                    <th>
                                        <button type="button" class="btn btn-default"><span
                                                class="text-bold">Пользователь</span></button>
                                    </th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}.</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('users.edit', $order->user_id) }}" type="button"
                                                   class="btn btn-default">
                                                    {{ $order->user->getFullName() }}
                                                </a>
                                                <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <form action="{{ route('orders.index') }}" method="get">
                                                        <input name="userId"
                                                               value="{{ $order->user_id }}"
                                                               type="hidden">
                                                        <button type="submit"
                                                                class="dropdown-item">Все заказы
                                                        </button>
                                                    </form>
                                                </div>
                                            </div><!-- /.order by User -->
                                        </td>
                                        <td>
                                            {{ $order->getStatusName() }}
                                        </td>
                                        <td class="d-flex"><a href="{{ route('orders.edit', $order->id) }}"
                                                              type="button"
                                                              class="btn btn-primary btn-sm mr-2">
                                                Редактировать
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $orders->onEachSide(2)->withQueryString()->links() }}
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
