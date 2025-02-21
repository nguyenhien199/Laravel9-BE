<?php

/**
 * ==================== SYSTEM TABLE GROUP ====================
 */
const TABLE_MIGRATION = 'sys_migrations';                 // Database migrations table
const TABLE_JOB = 'sys_jobs';                             // Jobs table
const TABLE_JOB_BATCH = 'sys_job_batches';                // Job batches table
const TABLE_FAILED_JOB = 'sys_failed_jobs';               // Job failed history table
const TABLE_SESSION = 'sys_sessions';                     // System Session table
const TABLE_ACTIVITY_LOG = 'sys_activity_logs';           // System Activity logs table

/**
 * ==================== AUTH TABLE GROUP ====================
 */
const TABLE_USER = 'users';                                         // Users table
const TABLE_PASSWORD_RESET_TOKEN = 'password_reset_tokens';         // Password reset tokens table
const TABLE_PASSWORD_HISTORY = 'password_histories';                // Password histories table
