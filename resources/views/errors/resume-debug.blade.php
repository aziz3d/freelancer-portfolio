<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Debug Information</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .error-code { font-size: 48px; color: #e74c3c; font-weight: bold; margin-bottom: 20px; }
        .error-title { font-size: 24px; color: #2c3e50; margin-bottom: 15px; }
        .debug-section { background: #ecf0f1; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .debug-title { font-weight: bold; color: #2c3e50; margin-bottom: 10px; }
        .path-list { list-style: none; padding: 0; }
        .path-list li { padding: 5px 0; font-family: monospace; background: #fff; margin: 2px 0; padding: 8px; border-radius: 3px; }
        .btn { display: inline-block; padding: 12px 24px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
        .btn:hover { background: #2980b9; }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #229954; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        <div class="error-title">Resume File Debug Information</div>
        
        <div class="debug-section">
            <div class="debug-title">Database Information:</div>
            <p><strong>Resume Path in Database:</strong> {{ $resumePath ?? 'Not set' }}</p>
            <p><strong>Resume Settings:</strong></p>
            <pre>{{ json_encode($resumeSettings->meta ?? [], JSON_PRETTY_PRINT) }}</pre>
        </div>
        
        <div class="debug-section">
            <div class="debug-title">Searched Paths:</div>
            <ul class="path-list">
                @foreach($searchedPaths as $path)
                    <li>{{ $path }}</li>
                @endforeach
            </ul>
        </div>
        
        <div class="debug-section">
            <div class="debug-title">Storage Information:</div>
            <p><strong>Storage Path:</strong> {{ storage_path('app/public') }}</p>
            <p><strong>Public Path:</strong> {{ public_path('storage') }}</p>
        </div>
        
        <div class="debug-section">
            <div class="debug-title">Next Steps:</div>
            <ol>
                <li>Go to Admin Panel → About Page Settings</li>
                <li>Find the "Resume Settings" section</li>
                <li>Upload a new resume file</li>
                <li>Save the settings</li>
                <li>Try downloading again</li>
            </ol>
        </div>
        
        <a href="{{ route('about') }}" class="btn">← Back to About Page</a>
        <a href="{{ route('debug.resume') }}" class="btn btn-success">View Debug JSON</a>
    </div>
</body>
</html>