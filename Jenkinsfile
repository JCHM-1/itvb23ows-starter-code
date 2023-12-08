/* Requires the Docker Pipeline plugin */
pipeline {
    agent {
        docker { image 'node:20.10.0-alpine3.18' } 
    }
    stages {
        stage('Build') {
            steps {
                sh 'python --version'
                sh 'echo "Hello World"'
                sh '''
                    echo "Multiline shell steps works too"
                    ls -lah
                '''
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