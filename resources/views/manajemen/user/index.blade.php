@extends('layouts.admin')

@section('title','Manajemen User')

@section('content')

<div class="page-header">
    <h3 class="page-title">Manajemen User</h3>
</div>

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">

<div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="card-title mb-0">Daftar Pengguna</h4>

        <a href="{{ route('manajemen.user.create') }}" class="btn btn-primary btn-sm">
            + Tambah User
        </a>
    </div>

    <div class="table-responsive">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)

                <tr>
                    <td>{{ $user->nama }}</td>

                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="badge 
                        {{ $user->role === 'admin' ? 'badge-success' : 'badge-primary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td class="text-center">

                        <a href="{{ route('manajemen.user.edit', $user) }}"
                           class="btn btn-sm btn-outline-primary"
                           title="Edit">
                           Edit
                        </a>

                        <form method="POST"
                              action="{{ route('manajemen.user.destroy', $user) }}"
                              style="display:inline-block;"
                              onsubmit="return confirm('Hapus user ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger"
                                    title="Hapus">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center">
                        Tidak ada user
                    </td>
                </tr>

                @endforelse
            </tbody>

        </table>

    </div>

</div>
</div>
</div>
</div>

@endsection