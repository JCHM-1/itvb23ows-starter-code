/* Requires the Docker Pipeline plugin , environment*/
pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo "The build ID of this job is ${BUILD_ID}"
            }
        }

        stage('Unit Tests') {
            steps {
                script {
                    docker.image('php:7.4-cli').inside {
                    sh 'composer install' // If needed
                    sh 'vendor/bin/phpunit'
                        }
                    }
                sh 'vendor/bin/phpunit'
                xunit([
                    thresholds: [
                        failed ( failureThreshold: "0" ),
                        skipped ( unstableThreshold: "0" )
                    ],
                    tools: [
                        PHPUnit(pattern: 'build/logs/junit.xml', stopProcessingIfError: true, failIfNotNew: true)
                    ]
                ])
                publishHTML([
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: false,
                    reportDir: 'build/coverage',
                    reportFiles: 'index.html',
                    reportName: 'Coverage Report (HTML)',
                    reportTitles: ''
                ])
                publishCoverage adapters: [coberturaAdapter('build/logs/cobertura.xml')]
            }
        }

        stage('SonarQube') {
            steps {
                script { scannerHome = tool 'sonarqube_jenkins' }
                    withSonarQubeEnv('sonarqube_jenkins') {
                        sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=OWS-sonarcube"
                }
            }   
        }

        stage('Deliver') {
            steps {
                echo "Delivering..."
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