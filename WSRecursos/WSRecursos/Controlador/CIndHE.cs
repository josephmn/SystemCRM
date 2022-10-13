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
    public class CIndHE
    {
        public List<EIndHE> Listar_IndHE(SqlConnection con)
        {
            List<EIndHE> lEIndHE = null;
            SqlCommand cmd = new SqlCommand("ASP_INDHORASEXTRAS", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndHE = new List<EIndHE>();

                EIndHE obEIndHE = null;
                while (drd.Read())
                {
                    obEIndHE = new EIndHE();
                    obEIndHE.v_periodo = drd["v_periodo"].ToString();
                    obEIndHE.f_HE25 = drd["f_HE25"].ToString();
                    obEIndHE.f_HE35 = drd["f_HE35"].ToString();
                    obEIndHE.f_HE100 = drd["f_HE100"].ToString();
                    obEIndHE.f_HEESP = drd["f_HEESP"].ToString();
                    lEIndHE.Add(obEIndHE);
                }
                drd.Close();
            }

            return (lEIndHE);
        }
    }
}