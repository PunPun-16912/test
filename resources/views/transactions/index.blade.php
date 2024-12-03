<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Transactions</h1>

        <!-- ฟอร์มสำหรับเพิ่มรายการ -->
        <form action="{{ route('transactions.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="amount" class="form-control" placeholder="Amount" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <input type="date" name="expense_date" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-control" required>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Add Transaction</button>
                </div>
            </div>
        </form>

        <!-- การแสดงรายการธุรกรรม -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Expense Date</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ $transaction->title }}</td>
                        <td>{{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ $transaction->expense_date }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td>
                            <!-- ปุ่มลบข้อมูล -->
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ฟอร์มค้นหาตามเดือน -->
    <div class="container d-flex justify-content-center align-items-center min-vh-20">
        <form action="{{ route('transactions.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
