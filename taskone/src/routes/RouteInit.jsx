import React, { Suspense } from 'react'
import { Routes, Route } from "react-router";
import { AboutPage } from '../pages/AboutPage';
import MainLayout from '../layouts/MainLayout';
import NoMatchPage from '../pages/NoMatchPage';
const HomePage = React.lazy(() => import('../pages/HomePage'));
const RouteInit = () => {
  return (
    <>
      <Routes >
        <Route element={< MainLayout />}>
          <Route index
            element={
              <Suspense fallback={<div>Loading...</div>}>
                <HomePage />
              </Suspense>
            } />
          <Route path="about" element={<AboutPage />} />
          <Route path="*" element={<NoMatchPage />} />
        </Route>
      </Routes>
    </>
  )
}

export default RouteInit