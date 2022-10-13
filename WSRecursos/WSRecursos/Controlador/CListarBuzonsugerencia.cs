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
    public class CListarBuzonsugerencia
    {
        public List<EListarBuzonsugerencia> ListarBuzonsugerencia(SqlConnection con, Int32 post)
        {
            List<EListarBuzonsugerencia> lEListarBuzonsugerencia = null;
            SqlCommand cmd = new SqlCommand("ASP_BUZON_SUGERENCIA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarBuzonsugerencia = new List<EListarBuzonsugerencia>();

                EListarBuzonsugerencia obEListarBuzonsugerencia = null;
                while (drd.Read())
                {
                    obEListarBuzonsugerencia = new EListarBuzonsugerencia();
                    obEListarBuzonsugerencia.i_id = drd["i_id"].ToString();
                    obEListarBuzonsugerencia.v_nombre = drd["v_nombre"].ToString();
                    lEListarBuzonsugerencia.Add(obEListarBuzonsugerencia);
                }
                drd.Close();
            }

            return (lEListarBuzonsugerencia);
        }
    }
}