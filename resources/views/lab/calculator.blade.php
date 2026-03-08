@extends('layouts.app')

@section('title', 'Calculator')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card card">
                <div class="card-header py-3">
                    <h1 class="h5 mb-0">Calculator</h1>
                </div>
                <div class="card-body">
                    <form id="calculatorForm" class="row g-3">
                        <div class="col-md-6">
                            <label for="numberA" class="form-label">First Number</label>
                            <input type="number" step="any" id="numberA" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="numberB" class="form-label">Second Number</label>
                            <input type="number" step="any" id="numberB" class="form-control" required>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary" data-op="add">Addition</button>
                            <button type="button" class="btn btn-secondary" data-op="subtract">Subtraction</button>
                            <button type="button" class="btn btn-success" data-op="multiply">Multiplication</button>
                            <button type="button" class="btn btn-warning" data-op="divide">Division</button>
                        </div>
                    </form>

                    <hr>

                    <div class="alert alert-info mb-0" id="resultBox">
                        Enter two numbers and choose an operation.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (() => {
        const numberA = document.getElementById('numberA');
        const numberB = document.getElementById('numberB');
        const resultBox = document.getElementById('resultBox');

        const operations = {
            add: (a, b) => a + b,
            subtract: (a, b) => a - b,
            multiply: (a, b) => a * b,
            divide: (a, b) => b === 0 ? null : a / b,
        };

        document.querySelectorAll('[data-op]').forEach((button) => {
            button.addEventListener('click', () => {
                const a = Number(numberA.value);
                const b = Number(numberB.value);

                if (Number.isNaN(a) || Number.isNaN(b)) {
                    resultBox.className = 'alert alert-danger mb-0';
                    resultBox.textContent = 'Please enter valid numbers first.';
                    return;
                }

                const op = button.getAttribute('data-op');
                const result = operations[op](a, b);

                if (result === null) {
                    resultBox.className = 'alert alert-danger mb-0';
                    resultBox.textContent = 'Division by zero is not allowed.';
                    return;
                }

                resultBox.className = 'alert alert-info mb-0';
                resultBox.textContent = `Result: ${result}`;
            });
        });
    })();
</script>
@endpush
