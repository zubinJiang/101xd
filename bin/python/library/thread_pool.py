#!/usr/bin/env python

import Queue, threading, sys, time
from threading import Thread

# working thread
class Worker(Thread):
    worker_count = 0
    timeout = 1
    def __init__( self, workQueue, resultQueue, **kwds):
        Thread.__init__( self, **kwds )
        self.id = Worker.worker_count
        Worker.worker_count += 1
        self.setDaemon(True)
        self.workQueue = workQueue
        self.resultQueue = resultQueue
        self.start( )
 
    def run( self ):
        while True:
            try:
                callable, args, kwds = self.workQueue.get(timeout=Worker.timeout)
                res = callable(*args, **kwds)
                print "worker[%2d]: %s" % (self.id, str(res) )
                self.resultQueue.put( res )
                #time.sleep(Worker.sleep)
            except Queue.Empty:
                break
            except :
                print 'worker[%2d]' % self.id, sys.exc_info()[:2]
                raise
              
class WorkerManager:
    def __init__( self, num_of_workers=10, timeout = 100):
        print 'teste'
        self.workQueue   = Queue.Queue()
        self.resultQueue = Queue.Queue()
        self.workers = []
        self.timeout = timeout
        self._recruitThreads( num_of_workers )
 
    def _recruitThreads( self, num_of_workers ):
        for i in range( num_of_workers ):
            worker = Worker( self.workQueue, self.resultQueue )
            self.workers.append(worker)
 
    def wait_for_complete( self):
        while len(self.workers):
            worker = self.workers.pop()
            worker.join( )
            if worker.isAlive() and not self.workQueue.empty():
                self.workers.append( worker )
 
    def add_job( self, callable, *args, **kwds ):
        self.workQueue.put( (callable, args, kwds) )
 
    def get_result( self, *args, **kwds ):
        return self.resultQueue.get( *args, **kwds )
