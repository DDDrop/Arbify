@extends('projects.layout')

@section('project-content')
    <div class="container">
        <div class="d-flex mb-4">
            <a href="{{ route('project-languages.create', $project) }}" class="btn btn-primary ml-auto">Add language</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

        <table class="table table-bordered table-striped bg-white mb-4">
            <colgroup>
                <col>
                <col style="width: 200px">
                <col style="width: 90px">
            </colgroup>
            <thead>
                <tr>
                    <th>Language</th>
                    <th>Progress</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($languages as $language)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if(!is_null($language->flag))
                                    <span class="flag-icon flag-icon-{{ $language->flag }} mr-2" style="font-size: 1.5em"></span>
                                @endif

                                {{ $language->getDisplayName() }}
                            </div>
                        </td>
                        <td>
                            @include('projects.translation-progress', ['statistics' => $statistics[$language->code]])
                        </td>
                        <td class="py-0 align-middle">
                            @can('manage-languages', [$project])
                                <form method="post" action="{{ route('project-languages.destroy', [$project, $language->code]) }}" class="d-inline delete delete-modal-show"
                                      data-delete-modal-title="Deleting language" data-delete-modal-body="<b>{{ $language->getDisplayName() }}</b> from this project">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-link btn-sm text-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">There is no language in this project.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection