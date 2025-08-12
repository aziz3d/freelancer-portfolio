<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Download Error</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .error-code { font-size: 48px; color: #e74c3c; font-weight: bold; margin-bottom: 20px; }
        .error-title { font-size: 24px; color: #2c3e50; margin-bottom: 15px; }
        .error-message { color: #7f8c8d; line-height: 1.6; margin-bottom: 25px; }
        .btn { display: inline-block; padding: 12px 24px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background: #2980b9; }
        .error-details { background: #ecf0f1; padding: 15px; border-radius: 4px; margin-top: 20px; font-size: 14px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">500</div>
        <div class="error-title">Resume Download Error</div>
        <div class="error-message">
            <p>An error occurred while trying to download the resume file. This is usually a temporary issue.</p>
            <p>Please try again in a few moments, or contact the administrator if the problem persists.</p>
        </div>
        
        <a href="{{ route('about') }}" class="btn">← Back to About Page</a>
        
        <div class="error-details">
            <strong>Error Details:</strong><br>
            {{ $error }}
        </div>
    </div>
</body>
</html>