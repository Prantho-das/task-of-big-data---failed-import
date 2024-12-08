import React, { useMemo } from 'react';
import myMatchData from "../../public/data.json";

const HomePage = () => {
  const mainMatchData = useMemo(() => myMatchData?.data ?? [], []);

  if (mainMatchData.length === 0) {
    return <h4 className="text-center">No Match Found</h4>;
  }

  const lastMatchData = mainMatchData[mainMatchData.length - 1];

  return (
    <div className="container">
      {lastMatchData?.matches?.match &&
        lastMatchData.matches.match.map((match, i) => (
          <div className="card my-3" key={i}>
            <div className="card-body">
              <h5 className="card-title text-center">{match?.date}</h5>
              <div className="row text-center">
                <div className="col-md-4">
                  {match?.localteam?.name} ({match?.localteam?.totalscore})
                </div>
                <div className="col-md-4">
                  <h2>{match?.time}</h2>
                  <h5>
                    {match?.localteam?.totalscore} / {match?.awayteam?.totalscore}
                  </h5>
                </div>
                <div className="col-md-4">
                  {match?.awayteam?.name} ({match?.awayteam?.totalscore})
                </div>
              </div>
              {match?.odds?.type?.map((oddType, key) => (
                <div key={key} className="mt-4">
                  <h5 className="text-center">{oddType?.value}</h5>
                  {Array.isArray(oddType?.bookmaker) && oddType?.bookmaker[0]?.odd?.length > 0 && (
                    <table className="table table-bordered mt-3">
                      <thead>
                        <tr>
                          <th scope="col">Bookmaker</th>
                          {oddType?.bookmaker[0]?.odd?.map((oddInfo, oddIndex) => (
                            <th scope="col" key={oddIndex}>
                              {oddInfo?.name}
                            </th>
                          ))}
                        </tr>
                      </thead>
                      <tbody>
                        {oddType?.bookmaker.map((bookmaker, indexKey) => (
                          <tr key={indexKey}>
                            <td>{bookmaker?.name}</td>
                            {bookmaker?.odd?.map((oddInfo, oddIndex) => (
                              <td key={oddIndex}>{oddInfo?.value}</td>
                            ))}
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  )}
                </div>
              ))}
            </div>
          </div>
        ))}
    </div>
  );
};

export default HomePage;
