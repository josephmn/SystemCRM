using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CBoletadetalle
    {
        public List<EBoletadetalle> Listar_Boletadetalle(SqlConnection con, String nroboleta)
        {
            List<EBoletadetalle> lEBoletadetalle = null;
            SqlCommand cmd = new SqlCommand("ASP_BOLETA_DETALLE", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@nroboleta", SqlDbType.VarChar).Value = nroboleta;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEBoletadetalle = new List<EBoletadetalle>();

                EBoletadetalle obEBoletadetalle = null;
                while (drd.Read())
                {
                    obEBoletadetalle = new EBoletadetalle();
                    obEBoletadetalle.NBRBOLETA = drd["NBRBOLETA"].ToString();
                    obEBoletadetalle.perpost = drd["perpost"].ToString();
                    obEBoletadetalle.DNI = drd["DNI"].ToString();
                    obEBoletadetalle.CANTIDAD = drd["CANTIDAD"].ToString();
                    obEBoletadetalle.RUBSOLES = drd["RUBSOLES"].ToString();
                    obEBoletadetalle.RUBTIPO = drd["RUBTIPO"].ToString();
                    obEBoletadetalle.RUBID = drd["RUBID"].ToString();
                    obEBoletadetalle.RUBDESC = drd["RUBDESC"].ToString();
                    lEBoletadetalle.Add(obEBoletadetalle);
                }
                drd.Close();
            }

            return (lEBoletadetalle);
        }
    }
}