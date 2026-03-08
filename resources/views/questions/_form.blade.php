@php
    $isEdit = isset($question) && $question->exists;
@endphp

<div class="row g-3">
    <div class="col-12">
        <label for="question_text" class="form-label">Question</label>
        <textarea id="question_text" name="question_text" rows="3" class="form-control" required>{{ old('question_text', $isEdit ? $question->question_text : '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="option_a" class="form-label">Option A</label>
        <input type="text" id="option_a" name="option_a" class="form-control" value="{{ old('option_a', $isEdit ? $question->option_a : '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="option_b" class="form-label">Option B</label>
        <input type="text" id="option_b" name="option_b" class="form-control" value="{{ old('option_b', $isEdit ? $question->option_b : '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="option_c" class="form-label">Option C</label>
        <input type="text" id="option_c" name="option_c" class="form-control" value="{{ old('option_c', $isEdit ? $question->option_c : '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="option_d" class="form-label">Option D</label>
        <input type="text" id="option_d" name="option_d" class="form-control" value="{{ old('option_d', $isEdit ? $question->option_d : '') }}" required>
    </div>

    <div class="col-md-4">
        <label for="correct_option" class="form-label">Correct Option</label>
        @php $selectedCorrect = old('correct_option', $isEdit ? $question->correct_option : 'A'); @endphp
        <select id="correct_option" name="correct_option" class="form-select" required>
            @foreach (['A', 'B', 'C', 'D'] as $option)
                <option value="{{ $option }}" {{ $selectedCorrect === $option ? 'selected' : '' }}>{{ $option }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="d-flex gap-2 pt-4">
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('lab3.questions.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

