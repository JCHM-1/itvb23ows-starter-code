/* Requires the Docker Pipeline plugin */
pipeline {
    agent {
        docker { image 'php:8.3.0-alpine3.18' } 
    }

    environment {
        BUILD_ID = '1'
    }

    stages {
        stage('Build') {
            steps {
                sh 'php --version'
                sh 'echo "Hello World"'
                sh 'echo "The build ID of this job is ${BUILD_ID}"'
            }
        }
    }
    post {
        success {
            echo 'This will run only if successful'
        }
        failure {
            echo 'This will run only if failed'
        }
    }
}