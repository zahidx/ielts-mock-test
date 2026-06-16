@php $grouped = $questions->groupBy('group_label'); @endphp
@foreach($grouped as $label => $groupQuestions)
<div class="q-group">
    @if($label)<div class="q-group-label">{{ $label }}</div>@endif
    @foreach($groupQuestions as $q)
    <div class="question-item" id="q-{{ $q->id }}">
        <div class="d-flex align-items-start">
            <span class="q-num">{{ $q->question_number }}</span>
            <div class="flex-grow-1">
                <div class="q-text">{!! nl2br(e($q->question_text)) !!}</div>
                @if($q->question_type === 'mcq')
                    @foreach($q->options as $opt)
                    <label class="option-row">
                        <input type="radio" name="q_{{ $q->id }}" value="{{ $opt->label }}" {{ (isset($existingAnswers[$q->id]) && $existingAnswers[$q->id]===$opt->label) ? 'checked' : '' }}>
                        <span class="option-label">{{ $opt->label }}.</span><span>{{ $opt->option_text }}</span>
                    </label>
                    @endforeach
                @elseif($q->question_type === 'true_false_ng')
                    <select class="form-select form-select-sm tf-select" data-qid="{{ $q->id }}" style="width:200px">
                        <option value="">-- Select --</option>
                        @foreach(['TRUE','FALSE','NOT GIVEN'] as $v)
                        <option value="{{ $v }}" {{ (isset($existingAnswers[$q->id]) && $existingAnswers[$q->id]===$v) ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                @elseif(in_array($q->question_type, ['fill_blank','short_answer']))
                    <input type="text" class="fill-input" data-qid="{{ $q->id }}" value="{{ $existingAnswers[$q->id] ?? '' }}" placeholder="Type your answer">
                @elseif($q->question_type === 'matching')
                    @if($q->options->count())
                    <select class="form-select form-select-sm tf-select" data-qid="{{ $q->id }}" style="width:300px">
                        <option value="">-- Select --</option>
                        @foreach($q->options as $opt)
                        <option value="{{ $opt->label }}" {{ (isset($existingAnswers[$q->id]) && $existingAnswers[$q->id]===$opt->label) ? 'selected' : '' }}>{{ $opt->label }}. {{ $opt->option_text }}</option>
                        @endforeach
                    </select>
                    @else
                    <input type="text" class="fill-input" data-qid="{{ $q->id }}" value="{{ $existingAnswers[$q->id] ?? '' }}" placeholder="Type your answer">
                    @endif
                @endif
                <button class="btn btn-sm btn-outline-secondary mt-1" onclick="clearAnswer({{ $q->id }})"><i class="bi bi-x-circle"></i> Clear</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach