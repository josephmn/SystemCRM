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
    public class CBoletapago
    {
        public List<EBoletapago> Listar_Boletapago(SqlConnection con, String dni)
        {
            List<EBoletapago> lEBoletapago = null;
            SqlCommand cmd = new SqlCommand("ASP_BOLETA_PAGO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEBoletapago = new List<EBoletapago>();

                EBoletapago obEBoletapago = null;
                while (drd.Read())
                {
                    obEBoletapago = new EBoletapago();
                    obEBoletapago.nbrboleta = drd["nbrboleta"].ToString();
                    obEBoletapago.anhio = drd["anhio"].ToString();
                    obEBoletapago.periodoid = drd["periodoid"].ToString();
                    obEBoletapago.sneto = drd["sneto"].ToString();
                    lEBoletapago.Add(obEBoletapago);
                }
                drd.Close();
            }

            return (lEBoletapago);
        }
    }
}