<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-clipboard-data"></i> SurveyPro
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('surveys.index') }}">Surveys</a>
                <a class="nav-link" href="{{ route('questions.index') }}">Questions</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Survey Management Made Simple</h1>
            <p class="lead mb-5">Create, manage, and analyze surveys with our powerful and intuitive platform</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('surveys.index') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-clipboard"></i> Manage Surveys
                </a>
                <a href="{{ route('questions.index') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-question-circle"></i> Manage Questions
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col">
                    <h2 class="fw-bold">Powerful Features</h2>
                    <p class="text-muted">Everything you need to manage your surveys effectively</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-clipboard-plus display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Survey Management</h5>
                            <p class="card-text">Create and edit surveys with ease. Organize questions and manage multiple surveys simultaneously.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-collection display-4 text-success mb-3"></i>
                            <h5 class="card-title">Question Library</h5>
                            <p class="card-text">Build a comprehensive library of questions. Reuse questions across multiple surveys.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-lightning-charge display-4 text-warning mb-3"></i>
                            <h5 class="card-title">Mass Operations</h5>
                            <p class="card-text">Perform bulk actions on questions. Assign multiple questions to surveys or delete them in bulk.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="stat-number">
                        @php
                            $surveyCount = App\Models\Survey::count();
                            echo number_format($surveyCount);
                        @endphp
                    </div>
                    <p class="text-muted">Surveys Created</p>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number">
                        @php
                            $questionCount = App\Models\Question::count();
                            echo number_format($questionCount);
                        @endphp
                    </div>
                    <p class="text-muted">Questions Available</p>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number">
                        @php
                            $assignmentCount = DB::table('survey_question')->count();
                            echo number_format($assignmentCount);
                        @endphp
                    </div>
                    <p class="text-muted">Question Assignments</p>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-number">100%</div>
                    <p class="text-muted">Uptime Reliability</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Ready to Get Started?</h2>
            <p class="lead text-muted mb-4">Join thousands of users who trust our platform for their survey management needs</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('surveys.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Create Your First Survey
                </a>
                <a href="{{ route('questions.create') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Add New Question
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2023 SurveyPro. Built with Laravel & Bootstrap.</p>
            <small class="text-muted">Designed for GuildQuality Developer Coding Exercise</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>