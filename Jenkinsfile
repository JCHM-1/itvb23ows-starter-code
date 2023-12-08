/* Requires the Docker Pipeline plugin */
pipeline {
    agent {
        docker { image 'php:8.3.0-alpine3.18' } 
    }
    stages {
        stage('Build') {
            steps {
                sh 'php --version'
                sh 'echo "Hello World"'
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