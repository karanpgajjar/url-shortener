<x-app-layout>
    <div id="alert-zone">
        @if (session("success"))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session("success") }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>

    {{-- Member/Admin: create short URL --}}
    @if (auth()->user()->isAdmin() || auth()->user()->isMember())
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Generate Short URL</h5>
            <form id="short-url-form" class="row g-2">
                @csrf
                <div class="col-md-9">
                    <input type="url" name="original_url" class="form-control"
                        placeholder="e.g. https://example.com/some/long/path" required>
                    <div class="invalid-feedback" data-field="original_url"></div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="spinner-border spinner-border-sm d-none" data-spinner></span>
                        Generate
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- SuperAdmin: invite new company + admin --}}
    @if (auth()->user()->isSuperAdmin())
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Invite New Client Company</h5>
            <form id="invite-company-form" class="row g-2">
                @csrf
                <div class="col-md-3">
                    <input type="text" name="company[name]" class="form-control" placeholder="Company Name" required>
                    <div class="invalid-feedback" data-field="company.name"></div>
                </div>
                <div class="col-md-3">
                    <input type="email" name="company[email]" class="form-control" placeholder="Company Email" required>
                    <div class="invalid-feedback" data-field="company.email"></div>
                </div>
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Admin Name" required>
                    <div class="invalid-feedback" data-field="name"></div>
                </div>
                <div class="col-md-2">
                    <input type="email" name="email" class="form-control" placeholder="Admin Email" required>
                    <div class="invalid-feedback" data-field="email"></div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="spinner-border spinner-border-sm d-none" data-spinner></span>
                        Invite
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Companies</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Users</th>
                            <th>URLs</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                        <tr>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->users_count }}</td>
                            <td>{{ $company->short_urls_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $companies->links() }}
        </div>
    </div>
    @endif

    {{-- Admin: invite team member --}}
    @if (auth()->user()->isAdmin())
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Invite Team Member</h5>
            <form id="invite-team-form" class="row g-2">
                @csrf
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                    <div class="invalid-feedback" data-field="name"></div>
                </div>
                <div class="col-md-4">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="invalid-feedback" data-field="email"></div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select" required>
                        <option value="member" selected>Member</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="spinner-border spinner-border-sm d-none" data-spinner></span>
                        Invite
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Team Members</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teamMembers as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td><span class="badge bg-secondary">{{ $member->role->label() }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- All roles: their visible short URLs --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Generated Short URLs</h5>
            <div class="table-responsive">
                <table class="table table-sm" id="short-urls-table">
                    <thead>
                        <tr>
                            <th>Short URL</th>
                            <th>Original URL</th>
                            <th>Hits</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shortUrls as $shortUrl)
                        <tr>
                            <td><a href="{{ url('/s/'.$shortUrl->code) }}" target="_blank">{{ url("/s/".$shortUrl->code) }}</a></td>
                            <td class="text-truncate d-inline-block" style="max-width: 300px;">{{ $shortUrl->original_url }}</td>
                            <td>{{ $shortUrl->clicks }}</td>
                            <td>{{ $shortUrl->created_at->format("d M \ Y") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $shortUrls->links() }}
        </div>
    </div>
</x-app-layout>