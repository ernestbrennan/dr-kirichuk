First name: {{$user->first_name}} <br>
Last name: {{$user->last_name}} <br>
Email: {{$user->email}} <br>
Phone number: {{$user->phone}} <br>

Project name:  {{ $investment->name }}<br>
Investment: {{$percent->normal_percent}} \ {{$percent->percents}}% <br>
Risk\Strategy: {{$percent->risk->name}} <br>
Period:  {{$percent->period->month_count}}<br>
Divident payment - {{$dividend_payment_monthly ? 'Monthly' : 'In the end of the period'}}<br>
Long term termination - {{$long_term_termination ? "Yes" : "No"}} <br>
