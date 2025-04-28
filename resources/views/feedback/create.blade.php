<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Client Feedback</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">Client Feedback Form</h1>
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form class="space-y-6" id="feedbackForm" method="POST" action="{{ route('feedback.store') }}">
            @csrf

            <div>
                <label class="block font-medium text-gray-700">Customer Name</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('customer_name') border-red-500 @enderror" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('email') border-red-500 @enderror" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Phone Number</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('phone') border-red-500 @enderror" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Service Date</label>
                <input type="date" name="service_date" value="{{ old('service_date') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('service_date') border-red-500 @enderror" required>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Service Type</label>
                <select name="service_type"
                    class="w-full mt-1 p-2 border rounded-md @error('service_type') border-red-500 @enderror" required>
                    @foreach(\App\Models\Feedback::service_type() as $key => $label)
                        <option value="{{ $key }}" {{ old('service_type') == $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Job / Reference Number</label>
                <input type="text" name="job_reference" value="{{ old('job_reference') }}"
                    class="w-full mt-1 p-2 border rounded-md @error('job_reference') border-red-500 @enderror">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Location of Service</label>
                <select name="location"
                    class="w-full mt-1 p-2 border rounded-md @error('location') border-red-500 @enderror" required>
                    @foreach (\App\Models\Feedback::location() as $key => $label)
                        <option value="{{ $key }}" {{ old('location') == $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Satisfaction Rating (1 = Poor, 5 = Excellent)</label>
                <div class="flex gap-4 mt-2">
                    <label><input type="radio" name="satisfaction_rating" value="1" required> 1</label>
                    <label><input type="radio" name="satisfaction_rating" value="2"> 2</label>
                    <label><input type="radio" name="satisfaction_rating" value="3"> 3</label>
                    <label><input type="radio" name="satisfaction_rating" value="4"> 4</label>
                    <label><input type="radio" name="satisfaction_rating" value="5"> 5</label>
                </div>
            </div>

            <div>
                <label class="block font-medium text-gray-700">What aspects were you satisfied with?</label>
                <textarea name="satisfied_aspects" rows="3"
                    class="w-full mt-1 p-2 border rounded-md @error('satisfied_aspects') border-red-500 @enderror">{{ old('satisfied_aspects') }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">What could be improved?</label>
                <textarea name="improvements" rows="3"
                    class="w-full mt-1 p-2 border rounded-md @error('improvements') border-red-500 @enderror">{{ old('improvements') }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Was the staff professional and courteous?</label>
                <select name="staff_professional" class="w-full mt-1 p-2 border rounded-md">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Was the turnaround time acceptable?</label>
                <select name="turnaround_acceptable" class="w-full mt-1 p-2 border rounded-md">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Were the results/reports clear and
                    understandable?</label>
                <select name="reports_clear" class="w-full mt-1 p-2 border rounded-md">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Were safety and confidentiality maintained?</label>
                <select name="safety_confidentiality" class="w-full mt-1 p-2 border rounded-md">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Did you experience any issues or complaints?</label>
                <select name="issues_reported" class="w-full mt-1 p-2 border rounded-md">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">If yes, please describe the issue</label>
                <textarea name="issue_description" rows="3"
                    class="w-full mt-1 p-2 border rounded-md @error('issue_description') border-red-500 @enderror">{{ old('issue_description') }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Was the issue resolved to your satisfaction?</label>
                <select name="issue_resolved" class="w-full mt-1 p-2 border rounded-md">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                    {{-- <option value="null">N/A</option> --}}
                </select>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="follow_up_requested" id="followUp" class="mr-2" value="1">
                <label for="followUp" class="text-sm text-gray-700">I would like a follow-up</label>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Preferred contact method</label>
                <select name="preferred_contact_method"
                    class="w-full mt-1 p-2 border rounded-md @error('preferred_contact_method') border-red-500 @enderror"
                    required>
                    @foreach (\App\Models\Feedback::preferred_contact_method() as $key => $label)
                        <option value="{{ $key }}" {{ old('preferred_contact_method') == $key ? 'selected' : ''}}>{{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="consent" id="consent" class="mr-2" value="1" required>
                <label for="consent" class="text-sm text-gray-700">I consent to the storage and use of my feedback for
                    quality improvement.</label>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Date of Submission</label>
                <input type="date" name="submitted_on" class="w-full mt-1 p-2 border rounded-md" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white p-3 rounded-md font-semibold hover:bg-blue-700">Submit
                Feedback</button>
        </form>
    </div>
</body>
<script>
    document.getElementById('feedbackForm').addEventListener('submit', function (e) {
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerText = 'Submitting...';
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    });
</script>

</html>