<x-app-layout>
    <x-content-header pageTitle="Атрибуты">
        <li class="breadcrumb-item"><a href="{{ route('index') }}">Главная</a></li>
        <li class="breadcrumb-item active">Атрибуты</li>
    </x-content-header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mb-3">

                    <a href="{{ route('attributes.create') }}"
                       type="button"
                       class="btn btn-primary btn-flat mb-3 mr-2">
                        Добавить атрибут
                    </a>

                    <a href="{{ route('measure-units.index') }}"
                       type="button"
                       class="btn btn-primary btn-flat mb-3">
                        Единицы измерения
                    </a>

                    @if (session('status'))
                        <x-alert-success :message="session('status')"/>
                    @endif

                    @if(!empty($errors->get('attributeDeletion')))
                        <x-alert-danger :messages="$errors->get('attributeDeletion')"/>
                    @endif

                    <div class="card" style="border-radius: 0;">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tbody>
                                @php($i = 1)
                                @foreach($attributes as $attribute)
                                    <tr>
                                        <td style="width: 10px; padding-right: 0;">
                                            {{ $i }}.
                                        </td>
                                        <td>
                                            {{ $attribute->fullTitle }}
                                        </td>
                                        <td>
                                            <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-primary btn-sm btn-flat mr-2">
                                                Редактировать
                                            </a>
                                            <!-- Button trigger modal delete attribute -->
                                            <button class="btn btn-danger btn-sm btn-flat"
                                                    data-toggle="modal"
                                                    data-target="#modal-delete-attribute{{ $attribute->id }}">
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal delete attribute -->
                                    <div class="modal fade" id="modal-delete-attribute{{ $attribute->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Удалить атрибут
                                                        "{{ $attribute->fullTitle }}" ?
                                                    </h5>
                                                </div>

                                                <form action="{{ route('attributes.destroy', $attribute->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="modal-body">
                                                        <div class="mb-3 text-sm">
                                                            Если атрибут принадлежит хотя бы одной категории, его нельзя удалить.
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

                                    @php($i++)
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</x-app-layout>
