<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-row">
            {{ Form::label('tahun', 'Tahun', [
                'class' => 'col-sm-3 col-form-label',
                'style' => 'font-weight:bold;',
            ]) }}
            <div class="col-sm-9">
                <select class="form-control{{ $errors->has('tahun') ? ' is-invalid' : '' }}" name="tahun" required>
                    <option value="">Pilih Tahun</option>
                    @for ($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                {!! $errors->first(
                    'tahun',
                    '<div class="invalid-feedback">
                        :message</div>',
                ) !!}
            </div>
        </div>
        <div class="form-row mt-2">
            {{ Form::label('bulan', 'Bulan', ['class' => 'col-sm-3 col-form-label', 'style' => 'font-weight:bold;']) }}
            <div class="col-sm-9">
                <select class="form-control{{ $errors->has('bulan') ? ' is-invalid' : '' }}" name="bulan" required>
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
                {!! $errors->first(
                    'bulan',
                    '<div class="invalid-feedback">
                        :message</div>',
                ) !!}
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</div>
