{!! Form::open([
    'method' => 'GET',
    'url' => $url,
    'class' => 'navbar-form navbar-left',
    'role' => 'search',
]) !!}

<div class="input-group custom-search-form">

    <a href="{{ url($link . '/create') }}" class="btn btn-primary mr-2">
        <span class="glyphicon glyphicon-plus"></span>
        Tambah
    </a>

    <select class="form-control" name="tahun">
        <option value="all" {{ request()->input('tahun') == 'all' ? 'selected' : '' }}> Pilih Tahun - All</option>
        @for ($i = date('Y'); $i >= 2020; $i--)
            <option value="{{ $i }}" {{ request()->input('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>

    {{-- Dropdown for Bulan --}}
    <select class="form-control" name="bulan">
        <option value="all" {{ request()->input('bulan') == 'all' ? 'selected' : '' }}> Pilih Bulan - All</option>
        @for ($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ request()->input('bulan') == $i ? 'selected' : '' }}>
                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
            </option>
        @endfor
    </select>
    <span class="input-group-btn">
        <button class="btn btn-default-sm" type="submit">
            <i class="fa fa-search"></i>
        </button>
    </span>
</div>
{!! Form::close() !!}
