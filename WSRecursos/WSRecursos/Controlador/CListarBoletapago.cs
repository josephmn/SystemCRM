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
    public class CListarBoletapago
    {
        public List<EListarBoletapago> Listar_ListarBoletapago(SqlConnection con, String periodo)
        {
            List<EListarBoletapago> lEListarBoletapago = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_BOLETAS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@periodo", SqlDbType.VarChar).Value = periodo;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarBoletapago = new List<EListarBoletapago>();

                EListarBoletapago obEListarBoletapago = null;
                while (drd.Read())
                {
                    obEListarBoletapago = new EListarBoletapago();
                    obEListarBoletapago.nbrboleta = drd["nbrboleta"].ToString();
                    obEListarBoletapago.perid = drd["perid"].ToString();
                    obEListarBoletapago.pernombre = drd["pernombre"].ToString();
                    obEListarBoletapago.anhio = drd["anhio"].ToString();
                    obEListarBoletapago.periodoid = drd["periodoid"].ToString();
                    obEListarBoletapago.sneto = drd["sneto"].ToString();
                    lEListarBoletapago.Add(obEListarBoletapago);
                }
                drd.Close();
            }

            return (lEListarBoletapago);
        }
    }
}